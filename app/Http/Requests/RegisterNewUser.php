<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegisterNewUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        return [
            'name.required'        => 'আপনার নাম লিখুন।',
            'name.min'             => 'নাম অন্তত ৪ অক্ষরের হতে হবে।',
            'name.max'             => 'নাম সর্বাধিক ৪০ অক্ষরের হতে পারে।',
            'email.required'       => 'ইমেইল প্রদান করা আবশ্যক।',
            'email.email'          => 'বৈধ ইমেইল প্রদান করুন।',
            'email.unique'         => 'এই ইমেইলটি ইতিমধ্যে নেওয়া হয়েছে।',
            'password.required'    => 'পাসওয়ার্ড প্রদান করা আবশ্যক।',
            'password.min'         => 'পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে।',
            'password.max'         => 'পাসওয়ার্ড সর্বাধিক ১০০ অক্ষরের হতে পারে।',
            'agreed.required'      => 'আপনাকে শর্তাবলীতে সম্মতি দিতে হবে।',
            'TIMEOUT_OR_DUPLICATE' => 'গুগল রিক্যাপচা ব্যর্থ হয়েছে, দয়া করে আবার চেষ্টা করুন।',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules() : array
    {
        return [
            'name'                 => 'required|min:4|max:40',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|min:6|max:100',
            'agreed'               => 'required',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('signup_action')],
        ];
    }
}