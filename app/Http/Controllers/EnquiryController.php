<?php

namespace App\Http\Controllers;

use App\Model\TxnContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = TxnContactUs::orderBy('id', 'DESC')->paginate(50);
        return view('backend.admin.enquiries.index', compact('enquiries'));
    }

    public function create()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:191',
                'mobile' => 'required|digits_between:8,12',
                'subject' => 'required|string|max:191',
                'email' => 'required|email|max:191',
                'message' => 'required|string',
            ],
            [
                'name.required' => 'Please Enter Your Name',
                'mobile.required' => 'Please Enter Your Mobile Number',
                'mobile.digits_between' => 'Please Enter Mobile Number in digits between 8 to 12',
                'subject.required' => 'Please Enter Subject',
                'email.required' => 'Please Enter Email ID',
                'email.email' => 'Please Enter Proper Email ID',
                'message.required' => 'Please Enter Message',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Error', $validator->errors()->first());
            return redirect(route('contact'))->withInput();
        }

        $data = TxnContactUs::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'subject' => $request->subject,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        try {
            Mail::send(['html' => 'backend.mails.enquiry'], ['data' => $data], function ($message) {
                $message->from(env('MAIL_FROM_ADDRESS', 'info@ranayas.com'), 'Ranayas');
                $message->to('info@ranayas.com', 'Ranayas Admin');
                $message->subject('New Enquiry From Ranayas');
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact enquiry email: ' . $e->getMessage());
        }

        connectify('success', 'Enquiry Success', 'Thank you for contacting us, we\'ll get back to you soon !');

        return redirect(route('contact'));

    }
}
