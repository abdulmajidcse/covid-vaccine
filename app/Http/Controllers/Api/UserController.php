<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\SuccessResource;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        $response['message'] = "Successfully Registered! You'll get an email before vaccine schedule date.";
        return new SuccessResource($response);
    }

    /**
     * Search  for vaccine schedule by nid
     */
    public function search($nid)
    {
        $user = User::where('nid', $nid)->first();

        $response = [];
        if (!$user) {
            $response['message'] = 'Not registered';
            $response['data']['result_type'] = 'danger';
        } else if ($user->vaccine_date) {
            if ($user->vaccine_date < date('Y-m-d')) {
                $response['message'] = 'Vaccinated';
                $response['data']['result_type'] = 'success';
            } else {
                $response['message'] = 'Scheduled at ' . $user->vaccine_date;
                $response['data']['result_type'] = 'info';
            }
        } else {
            $response['message'] = 'Not scheduled';
            $response['data']['result_type'] = 'warning';
        }

        return new SuccessResource($response);
    }
}
