<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Gate;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = 'asc', $status = 0)
    {
        if(Gate::allows('is-user')) {
            $tickets = Ticket::where(['user_id' => Auth::id()])
            ->with('replies')
            ->paginate(10);           
            return view('user.tickets')->with(['tickets' => $tickets]);
        }       
        if(Gate::allows('is-admin')) {
            $status = $status == 0 ? 'desc' : 'asc';
            $tickets = Ticket::with('user')
            ->with('replies')
            ->with('replies.admin')
            ->orderBy('created_at', $date)
            ->orderBy('status', $status)
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
        if(Gate::allows('is-user')) {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if(Gate::allows('is-user')) {                  
            if(Gate::allows('user-ticket', $ticket)) {
                return view('user.ticket')->with(['ticket' => $ticket]);
            }
        }
        if(Gate::allows('is-admin')) {
            return view('admin.ticket')->with(['ticket' => $ticket]);
        }  
        return redirect('/home');
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
        if(Gate::allows('is-admin')) {
            $ticket->update([
                'status' => $ticket->status == 1 ? 0 : 1,
                'closed_at' => Carbon::now()->toDateTimeString()
            ]);
        }
        return redirect('/home');
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

    public function statistics()
    {
        //$tic
        return view('admin.statistics');
    }  
}
