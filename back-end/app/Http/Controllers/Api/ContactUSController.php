<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;

class ContactUSController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_contact'])->only('index', 'show');
        $this->middleware(['permission:delete_contact'])->only('destroy');
    }

    public function index()
    {
        $contact = Contact::all();
        return response()->json([
            'contact' => $contact
        ],200);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact = Contact::all();
        return response()->json([
            'contact' => $contact
        ],200);
    }

    public function sendMessage(Request $request) {

        $this->validate($request,[
            "name"     => "required|string|min:3|max:70",
            "email"    => "required|string|email|max:255",
            "message"  => "required|string",
        ]);

        $contact = new Contact;
        $contact->name    = $request->name;
        $contact->email   = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return response()->json([
            "success" => true,
            "message" => "Send Yor Message Is Successfully"
        ],201);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted Message IS Successfully"
        ],200);

    }
}
