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
	 * @return string
	 */
	public function messages()
	{
		return [
			// 'required'	=> 'Il est requis de compléter le champ correspondant au :required .',
			// 'phone' => 'Le champ téléphone est obligatoire.',
			// 'qty.min' => 'The quantity must be at least :min.',
			// 'preparation_method.required' => 'Description is required',
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
			'name' 	  	  => 'required|max:100',
			'phone'		  => 'required|digits_between:8,16',
			'email'		  => 'required|email',
			'message' 	  => 'required|min:10|max:2000',
			'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us_action')]
		];
	}
}