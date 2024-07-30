<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class StoreContactRequest extends FormRequest
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
            'name'    => 'আপনার নাম লিখুন',
            'email'   => 'আপনার ইমেইল লিখুন',
            'message' => 'আপনার মুল বক্তব্য বা মত্তব লিখুন',
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
            'name'                 => 'required|max:50',
            'email'                => 'required|email',
            'message'              => 'required|min:10|max:2000',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us_action')],
        ];
    }
}