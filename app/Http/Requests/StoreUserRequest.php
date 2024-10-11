<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Resources\ErrorResource;
use App\Models\VaccineCenter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190', Rule::unique(User::class)],
            'mobile' => ['required', 'numeric', 'digits:11', 'starts_with:01', Rule::unique(User::class)],
            'nid' => ['required', 'numeric', 'min_digits:10', 'max_digits:13', Rule::unique(User::class)],
            'address' => ['required', 'string', 'max:1000'],
            'vaccine_center_id' => ['required', 'numeric', 'min:1', Rule::exists(VaccineCenter::class, 'id')],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'vaccine_center_id' => 'vaccine center',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = (new ErrorResource($validator->errors()))->response()->setStatusCode(422);
        throw new ValidationException($validator, $response);
    }
}
