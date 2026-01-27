<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Product::class);
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
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'images' => 'required|array',
            'images.*.file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants' => 'nullable|array',
            'variants.*.variant_name' => 'required|string|max:100',
            'variants.*.description' => 'nullable|string',
            'variants.*.price' => 'required|numeric|min:0'
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
