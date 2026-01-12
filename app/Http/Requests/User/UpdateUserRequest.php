<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|min:3',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'msisdn' => 'required|string|min:13|max:14|unique:users',
            'password' => 'required|min:5',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'outlets'   => 'required|array|min:1',
            'outlets.*' => 'exists:outlets,id',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'statusMessage' => 'Unprocessable Entity',
                'statusDescription' => 'Validation failed for the given request',
                'result' => [
                    'errorCode' => '21',
                    'errorMessage' => 'Validation failed',
                    'errors' => $validator->errors(),
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
