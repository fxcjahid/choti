<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Traits\HasCrudActions;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'contact.contact';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'contact';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.contact';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = StoreContactRequest::class;

    /**
     * Redirect to url after saving a resource.
     *
     * @param \App\Http\Controllers\ContactController $contact
     * @return \Illuminate\Http\Response
     */
    // protected function redirectTo($contact)
    // {
    //     return redirect()->route('admin.menus.edit', $contact);
    // }


    /**
     * Admin View
     */
    // public function index()
    // {
    //     $data = Contact::all();

    //     return view('admin.views.contact.index', compact('data'));
    // } 

}