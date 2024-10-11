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
}
