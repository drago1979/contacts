<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

//        dd($contacts[0]->phoneNumbers);
//
//        dd($contacts->phoneNumbers);
        return view('contacts.show_all', compact('contacts'));
    }
}
