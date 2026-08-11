<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Returnticket;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ReturnticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Returnticket::orderBy('id', 'DESC')->paginate(50);
        return view('backend.admin.return-tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $ticket = Returnticket::where('id', $id)->firstOrFail();
            return view('backend.admin.return-tickets.edit', compact('ticket'));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Ticket Not Found !');

                return redirect(route('admin.return-tickets.all'));
            }

            connectify('error', 'Error', 'Whoops, something went wrong, try again later');

            return redirect(route('admin.return-tickets.all'));

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'description' => 'nullable|string',
                'status' => 'required|integer|max:1',
            ],
            [
                'status.required' => 'Please Select Status',
                'status.max' => 'Invalid status provided',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Error', $validator->errors()->first());
            return back()->withInput();
        }

        try {

            $ticket = Returnticket::where('id', $id)->firstOrFail();

            $ticket->update([
                'description' => $request->description,
                'status' => $request->status,
            ]);

            if ($ticket->status == false) {

                $ticket->update([
                    'closed_at' => now(),
                ]);

                try { Mail::send(['html' => 'backend.mails.ticket-closed'], ['ticket' => $ticket], function ($message) use ($ticket) {
                    $message->from('info@ranayas.com', 'Ranayas ');
                    $message->to($ticket->email, 'Ranayas');
                    $message->subject('Closed:' . $ticket->subject . ' Ticket ID : ' . $ticket->id);
                }); } catch (\Exception $e) { \Log::error("Mail sending failed: " . $e->getMessage()); }

                connectify('success', 'Ticket Closed', 'Ticket has been Closed successfully with Ticket id : ' . $ticket->id);

                return redirect(route('admin.return-tickets.all'));

            }

            connectify('success', 'Ticket Closed', 'Ticket has been updated successfully with Ticket id : ' . $ticket->id);

            return redirect(route('admin.return-tickets.all'));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Ticket Not Found !');

                return redirect(route('admin.return-tickets.all'));
            }

            connectify('error', 'Error', 'Whoops, something went wrong, try again later');

            return redirect(route('admin.return-tickets.all'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
