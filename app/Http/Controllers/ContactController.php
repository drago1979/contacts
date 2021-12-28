<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function editAll()
    {
        $contacts = Contact::all();

        return view('contacts.edit_all', compact('contacts'));
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
    }
}
