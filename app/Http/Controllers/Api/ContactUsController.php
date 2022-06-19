<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function store(ContactRequest $request)
    {

        $validateData = $request->validated();
        $contact = Contact::create($validateData);/*[
            'Subject' => $validateData['subject'],
            'Name' => $validateData['name'],
            'Email' => $validateData['email'],
            'PhoneNumber' => $validateData['phoneNumber'],
            'Text' => $validateData['text']
        ]);*/

        $reponse = [
            'status' => 1,
            'data' => 'contant successfully saved.',
            'text' => ''
        ];

        return $reponse;

    }
}
