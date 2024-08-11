<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class WriteNewStoryUpdateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'    => 'exists:posts,id',
            'name'  => 'min:3|max:100',
            'email' => 'email',
            // 'category'             => ['nullable', 'integer', 'exists:categories,id'],
            // 'series'               => ['nullable', 'integer', 'exists:series,id'],
            // 'tags'                 => ['nullable', 'integer', 'exists:tags,id'],
            // 'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('update_story_action')],
        ];

        // Another way to validation number
        // $rules = [
        //     'id'    => 'exists:posts,id',
        //     'name'  => 'min:3|max:100',
        //     'email' => 'email',
        // ];

        // if (is_numeric($this->category)) {
        //     $rules['category'] = 'exists:categories,id';
        // }

        // if (is_numeric($this->series)) {
        //     $rules['series'] = 'exists:series,id';
        // }

        // if (is_array($this->tags)) {
        //     $rules['tags.*'] = 'exists:tags,id';
        // }

        // return $rules;
    }
}