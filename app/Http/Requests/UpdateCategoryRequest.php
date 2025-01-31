<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
			'id'	  	  => 'required|exists:categories,id',
			'name' 	  	  => 'required|max:100|unique:categories,name,' . $this->id,
			'slug'		  => 'nullable|max:100|unique:categories,slug,' . $this->id, // Ignore unique verifation on same ID 
			'description' => 'nullable|min:10|max:2000',
		];
	}
}