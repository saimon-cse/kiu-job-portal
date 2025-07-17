<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Since the route is already protected by 'auth' middleware,
        // we can simply return true here. Any authenticated user can update their own profile.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Rules for the 'users' table
            // 'name' => ['required', 'string', 'max:255'],
            // The email must be unique, but we need to ignore the current user's own email.
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],

            // Rules for the 'user_profiles' table
            'full_name_bn' => ['nullable', 'string', 'max:255'],
            'full_name_en' => ['nullable', 'string', 'max:255'],
            'father_name_bn' => ['nullable', 'string', 'max:255'],
            'father_name_en' => ['nullable', 'string', 'max:255'],
            'mother_name_en' => ['nullable', 'string', 'max:255'],
            'mother_name_bn' => ['nullable', 'string', 'max:255'],
            'spouse_name_en' => ['nullable', 'string', 'max:255'],
            'spouse_name_bn' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'permanent_address_bn' => ['nullable', 'string'],
            'permanent_address_en' => ['nullable', 'string'],
            'present_address_bn' => ['nullable', 'string'],
            'present_address_en' => ['nullable', 'string'],
            'phone_mobile' => ['nullable', 'string', 'max:20'],
            'additional_information' => ['nullable', 'string'],
            'quota_information' => ['nullable', 'string'],
            'adittional_information' => ['nullable', 'string'],
            'dismissal_reason' => ['nullable', 'string'],
            'service_obligation_details' => ['nullable', 'string'],
        ];
    }
}
