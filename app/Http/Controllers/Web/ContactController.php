<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactRequest;
use App\Models\Contact;
use App\Notifications\Notification;
use Exception;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('web.contact.index');
    }

    public function store(ContactRequest $request)
    {
        $contact = new Contact();
        $contact->fill($request->validated());
        $contact->save();

        try {
            $contact->notify(new Notification(
                via: ['mail'],
                holder: 'web',
                category: 'contact',
                action_to_receiver: __FUNCTION__ . '_to_user',
                data: [
                    'mail' => [
                        'mail_objects' => [
                            $contact,
                        ],
                        'cc' => [
                            'email1@example.com',
                            'email2@example.com',
                        ],
                        'bcc' => [
                            'email3@example.com',
                            'email4@example.com',
                        ],
                    ],
                ],
            ));
        } catch (Exception $e) {
            Log::error($e);
        }

        

        return back()->with('success', __('flash_message.success.create', ['id' => $contact->id, 'name' => $contact->title]));
    }
}
