<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class ContactPhoneController extends Controller
{
    public function getPayload(Request $request)
    {
        !($contacts = $request->input('contacts')) ?: $this->updateExistingContacts($contacts);

        !($newContacts = $request->input('new_contacts')) ?: $this->createNewContacts($newContacts);

        return redirect(route('contacts.edit_all'));

    }

    /* Updates existing contact info (f_name, l_name) and phone_number attributes
       and adds new numbers */
    public function updateExistingContacts($contacts)
    {
        foreach ($contacts as $contact) {
            $dbContact = Contact::find($contact['id']);

            foreach ($contact['phone_numbers'] as $phoneNumber) {

                $dbContact->phoneNumbers()->updateOrCreate(
                    ['id' => $phoneNumber['id']],
                    ['description' => $phoneNumber['description'], 'number' => $phoneNumber['number']]
                );
            }

            $dbContact->update($contact);

        }
    }

    // Creates new contacts with phone numbers
    public function createNewContacts($newContacts)
    {
        foreach ($newContacts as $newContact) {

            $dbContact = Contact::create($newContact);

            foreach ($newContact['phone_numbers'] as $phoneNumber) {

                $dbContact->phoneNumbers()->create($phoneNumber);
            }
        }
    }

}
