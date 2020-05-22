<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //USER GATE --CREATE LATER
        if(Auth::user()->role() === 'user') {
            $tickets = Ticket::where(['user_id' => Auth::id()])
            ->with('replies')
            ->get();           
            return view('user.tickets')->with(['tickets' => $tickets]);
        }
        //ADMIN GATE --CREATE LATER
        if(Auth::user()->role() === 'admin') {
            $tickets = Ticket::with('user')
            ->with('replies')
            ->with('replies.admin')
            ->paginate(10);
            return view('admin.tickets')->with(['tickets' => $tickets]);
        }        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //GATE FOR USER
        return view('user.create-ticket');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //GATE FOR USER
        $ticket = new Ticket([
            'tck_no' => 129345566,
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description
        ]);
        if($ticket->save()) {
            return redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //USER GATE --CREATE LATER
        if(Auth::user()->role() === 'user') {
            //$tickets = Ticket::where(['user_id' => Auth::id()])->with('replies')->get();           
            return view('user.ticket')->with(['ticket' => $ticket]);
        }
        //ADMIN GATE --CREATE LATER
        if(Auth::user()->role() === 'admin') {
            //$tickets = Ticket::paginate(10);
            return view('admin.ticket')->with(['ticket' => $ticket]);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
