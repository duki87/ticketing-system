<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Ticket;
use Auth;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewReply;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Ticket $ticket)
    {
        if($ticket->status == 1) {
            $request->validate([
                'reply' => ['required', 'string', 'min:5', 'max:255']
            ]);
            if(Gate::allows('is-admin')) {
                $reply = new Reply([
                    'admin_id' => Auth::id(),
                    'ticket_id' => $ticket->id,
                    'reply' => $request->reply
                ]);
                $reply->save();
                $user = $ticket->user;
                $user->notify(new NewReply($ticket, $user));
            }
            if(Gate::allows('is-user')) {
                $reply = new Reply([
                    'ticket_id' => $ticket->id,
                    'reply' => $request->reply
                ]);
                $reply->save();
            }
            return redirect()->back();
        }
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
