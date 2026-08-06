<?php

namespace App\Http\Controllers;

use App\Model\MailLog;
use App\Model\TxnContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                'name'    => 'required|string|max:191',
                'mobile'  => 'required|digits_between:8,12',
                'subject' => 'required|string|max:191',
                'email'   => 'required|email|max:191',
                'message' => 'required|string',
            ],
            [
                'name.required'         => 'Please Enter Your Name',
                'mobile.required'       => 'Please Enter Your Mobile Number',
                'mobile.digits_between' => 'Please Enter Mobile Number in digits between 8 to 12',
                'subject.required'      => 'Please Enter Subject',
                'email.required'        => 'Please Enter Email ID',
                'email.email'           => 'Please Enter Proper Email ID',
                'message.required'      => 'Please Enter Message',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Error', $validator->errors()->first());
            return redirect(route('contact'))->withInput();
        }

        // reCAPTCHA v2 verification
        $recaptchaToken = $request->input('g-recaptcha-response');
        if (empty($recaptchaToken)) {
            connectify('error', 'Error', 'Please complete the CAPTCHA verification before submitting.');
            return redirect(route('contact'))->withInput();
        }

        $recaptchaVerify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptchaToken,
            'remoteip' => $request->ip(),
        ]);

        if (!$recaptchaVerify->json('success')) {
            connectify('error', 'CAPTCHA Failed', 'CAPTCHA verification failed. Please tick the "I\'m not a robot" box and try again.');
            return redirect(route('contact'))->withInput();
        }

        $data = TxnContactUs::create([
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'subject' => $request->subject,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        try {
            Mail::send(['html' => 'backend.mails.enquiry'], ['data' => $data], function ($message) {
                $message->from(env('MAIL_FROM_ADDRESS', 'info@ranayas.com'), 'Ranayas');
                $message->to('info@ranayas.com', 'Ranayas Admin');
                $message->subject('New Enquiry From Ranayas');
            });

            // Log success
            MailLog::create([
                'from_name'     => $request->name,
                'from_email'    => $request->email,
                'phone'         => $request->mobile,
                'subject'       => $request->subject,
                'message'       => $request->message,
                'form_source'   => 'Contact Page',
                'status'        => 'success',
                'error_message' => null,
                'error_code'    => null,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact enquiry email: ' . $e->getMessage());

            // Log failure with full error detail + stack trace
            MailLog::create([
                'from_name'     => $request->name,
                'from_email'    => $request->email,
                'phone'         => $request->mobile,
                'subject'       => $request->subject,
                'message'       => $request->message,
                'form_source'   => 'Contact Page',
                'status'        => 'failed',
                'error_message' => $e->getMessage() . "\n\nStack Trace:\n" . $e->getTraceAsString(),
                'error_code'    => $e->getCode() ?: null,
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
            ]);
        }

        connectify('success', 'Enquiry Success', 'Thank you for contacting us, we\'ll get back to you soon !');

        return redirect(route('contact'));
    }
}
