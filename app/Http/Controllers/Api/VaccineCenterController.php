<?php

namespace App\Http\Controllers\Api;

use App\Models\VaccineCenter;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;

class VaccineCenterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $response['data'] = VaccineCenter::select('id as value', 'name')->get();
        $response['message'] = "All vaccine center list";

        return new SuccessResource($response);
    }
}
