<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPhoneRequest;
use App\Models\Contact;


class ContactPhoneController extends Controller
{
    public function getPayload(ContactPhoneRequest $request)
    {
        !($contacts = $request->input('contacts')) ?: $this->updateExistingContacts($contacts);

        !($newContacts = $request->input('new_contacts')) ?: $this->createNewContacts($newContacts);

        return redirect(route('contacts.edit_all'))->with('reload_after_save', true);

    }

    /* Updates existing contact info (f_name, l_name) and phone_number attributes
       and adds new numbers */
    public function updateExistingContacts($contacts)
    {
        foreach ($contacts as $contact) {
            $dbContact = Contact::find($contact['id']);
//
//            dd(isset($contact['phone_numbers']));
//            dd(gettype($contact['phone_numbers']));

            // If existing contact has no phone numbers, we will skip updateOrCreate
            if (isset($contact['phone_numbers'])) {

                foreach ($contact['phone_numbers'] as $phoneNumber) {

                    $dbContact->phoneNumbers()->updateOrCreate(
                        ['id' => $phoneNumber['id']],
                        ['description' => $phoneNumber['description'], 'number' => $phoneNumber['number']]
                    );
                }
            }

            $dbContact->update($contact);
        }
    }

    // Creates new contacts with phone numbers
    public function createNewContacts($newContacts)
    {
        foreach ($newContacts as $newContact) {

            $dbContact = Contact::create($newContact);

            // If no numbers were added to new contact, we will skip "create" numbers
            if (isset($newContact['phone_numbers'])) {
                foreach ($newContact['phone_numbers'] as $phoneNumber) {

                    $dbContact->phoneNumbers()->create($phoneNumber);
                }
            }
        }
    }

}
