<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست ارتباط با ما');

        $contacts = Contact::GetContact();

        return view('panel.contact.index',compact('contacts'));
    }

    public function show(Contact $contact)
    {
        \Head::SetTitle('contact');

        return view('panel.contact.show',compact('contact'));
    }

    public function update(Contact $contact)
    {
        $contact->update([
            'Status' => 'Read'
        ]);

        $response = [
            'status' => 1,
            'data' => 'update',
            'text' => ''
        ];

        return $response;
    }

    public function filter($filter)
    {
        \Head::SetTitle('لیست ارتباط با ما');

        if($filter = 'UnRead' || $filter == "Read") {
            $contacts = Contact::GetContact(['Status' => $filter])->get();
        }else{
            $contacts = Contact::GetContact();
        }

        return view('panel.contact.index',compact('contacts'));
    }
}
