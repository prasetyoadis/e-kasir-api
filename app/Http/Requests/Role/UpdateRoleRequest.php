<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    protected Role $role;

    protected function prepareForValidation(): void
    {
        $this->role = $this->route('role');
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $role = $this->route('role');

        return [
            # Make sure name is unique diferent.
            'name' => [
                'required',
                'min:3',
                ($this->name !== $this->role->name)  ? 'unique:users' : ''],
            # Make sure slug is unique diferent.
            'slug' => [
                'required',
                'min:3',
                ($this->slug !== $this->role->slug) ? 'unique:users' : ''],
            'description' => 'required|min:3'
        ];
    }
}
