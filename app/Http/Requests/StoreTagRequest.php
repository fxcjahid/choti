<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
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
			'name' 	  	  => 'required|unique:tags|max:100',
			'slug'		  => 'nullable|unique:tags|max:100|regex:/^[A-Za-z-_]+$/',
			'description' => 'nullable|min:10|max:2000',
		];
	}
}