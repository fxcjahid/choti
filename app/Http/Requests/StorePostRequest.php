<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
			'id'	  	=> 'required|exists:posts,id',
			'name'	  	=> 'required|max:255|unique:posts,name,' . $this->id,
			'slug'	  	=> 'alpha_dash|unique:posts,slug,' . $this->id,
			'status' 	=> 'in:publish,draft,scheduled,trash',
			'content' 	=> 'required',
			'tag' 		=> 'exists:tags,id',
			'category' 	=> 'exists:categories,id',
			'thumbnail.*.id' => 'exists:files,id'
		];
	}
}