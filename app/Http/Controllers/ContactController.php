<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
	/**
	 * Public View
	 */
	public function view()
	{
		return view('public.page.contact');
	}

	/**
	 * Admin View
	 */
	public function index()
	{
		$data = Contact::all();

		return view('admin.views.contact.index', compact('data'));
	}

	/**
	 * Admin: show contact
	 */
	public function show()
	{
	}


	/**
	 * Store new data
	 */
	public function store(StoreContactRequest $request)
	{
		$request = $request->only([
			'name',
			'phone',
			'email',
			'message'
		]);

		try {
			Contact::create($request);
		} catch (\Throwable $th) {
			throw $th;
		}

		return Redirect::back()
			->with('success', 'Merci ! <br/> Votre message a été envoyé avec succès. Nous vous contacterons très bientôt !');
	}
}