<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
//    public function destroy(PhoneNumber $phoneNumber)
    public function destroy(Contact $contact, PhoneNumber $phoneNumber)
    {
        $phoneNumber->delete();
    }
}
