<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\VaccineScheduleNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class VaccineScheduleService
{
    public function __invoke()
    {
        try {
            // get oldest 5 users based on ‘first come first serve’ strategy
            $notScheduledUsers = User::with('vaccineCenter')
                ->whereNull('vaccine_date')
                ->oldest('created_at')
                ->select('id', 'vaccine_center_id', 'vaccine_date')
                ->take(5)->get();

            foreach ($notScheduledUsers as $notScheduledUser) {
                // schedule vaccine for the user
                $lastDateOfCenter = User::whereNotNull('vaccine_date')
                    ->where('vaccine_center_id', $notScheduledUser->vaccine_center_id)
                    ->select('vaccine_center_id', 'vaccine_date')->latest('vaccine_date')->first();

                // set vaccine schedule date for this user
                if ($lastDateOfCenter) {
                    $scheduledUsersCount = User::whereNotNull('vaccine_date')
                        ->where('vaccine_center_id', $notScheduledUser->vaccine_center_id)
                        ->select('vaccine_center_id', 'vaccine_date')->latest('vaccine_date')->count();

                    if ($notScheduledUser->vaccineCenter->day_limit > $scheduledUsersCount) {
                        // set available  date for this user
                        $availableDate = $lastDateOfCenter->vaccine_date;
                    } else {
                        // set available  date for this user
                        $availableDate = Carbon::parse($lastDateOfCenter->vaccine_date)->addDays(1);
                    }
                } else {
                    // set available  date for this user
                    $availableDate = date('Y-m-d');
                }

                if ($availableDate == date('Y-m-d')) {
                    /**
                     * Update 1 day from today
                     * Because have to send a notification email to the users at 9 PM 
                     * before the night of their scheduled vaccination date
                     */
                    $availableDate = Carbon::parse($availableDate)->addDays(1);
                }

                // ignore Friday and Satureday
                $todayName = Carbon::parse($availableDate)->format('l');
                if ($todayName == 'Friday') {
                    $availableDate = Carbon::parse($availableDate)->addDays(2);
                } else if ($todayName == 'Saturday') {
                    $availableDate = Carbon::parse($availableDate)->addDays(1);
                }

                //  update vaccine schedule date for this user
                $notScheduledUser->update([
                    'vaccine_date' => $availableDate->format('Y-m-d'),
                ]);

                // send a notification to the users at 9 pm
                // before the night of their scheduled vaccination date
                $delay = Carbon::parse($availableDate)->subDays(1)->setTime(21, 0);
                $notScheduledUser->notify((new VaccineScheduleNotification($availableDate->format('Y-m-d')))->delay($delay));
            }
        } catch (\Throwable $th) {
            Log::channel('daily-custom')
                ->error('Vaccine Schedule Service Error: ' . $th->getMessage(), (array) $th);
        }
    }
}
