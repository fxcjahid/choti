<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class StoreComplainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'post_url.required' => 'পোষ্ট লিংক প্রয়োজনীয়।',
            'post_url.url'      => 'পোষ্ট লিংকটি একটি বৈধ URL হতে হবে।',
            'post_url.max'      => 'পোষ্ট লিংকটি সর্বোচ্চ 350 অক্ষর হতে পারে।',
            'message.required'  => 'আপনার মূল বক্তব্য বা মতামত লিখুন।',
            'message.min'       => 'বক্তব্যটি অন্তত 10 অক্ষরের এর কম হবে না',
            'message.max'       => 'বক্তব্যটি সর্বোচ্চ 2000 অক্ষর এর বেশি হবে না',
            'name.max'          => 'নামটি সর্বোচ্চ 50 অক্ষর এর বেশি হবে না',
            'name.alpha'        => 'নামে শুধুমাত্র অক্ষর থাকতে হবে',
            'email.email'       => 'আপনার ইমেইল এডড্রেস সঠিক নয়',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_url'             => 'required|url|max:350',
            'message'              => 'required|min:10|max:2000',
            'name'                 => 'nullable|max:50|alpha',
            'email'                => 'nullable|email',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us_action')],
        ];
    }
}