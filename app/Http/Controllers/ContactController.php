<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('contacts.show_all', compact('contacts'));
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
    }
}
