<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
use Gate;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            if(Gate::allows('is-user')) {
                $tickets = Ticket::where(['user_id' => Auth::id()])
                ->with('user')
                ->with('replies')
                ->with('admin_replies');
                return DataTables::of($tickets)
                ->addColumn('replies_no', function (Ticket $ticket) {
                    return count($ticket->replies);
                })
                ->editColumn('description', function (Ticket $ticket) {
                    return (substr($ticket->description, 0, 10) . '...');
                })
                ->editColumn('tck_no', function (Ticket $ticket) {
                    return '<a href="'.route('ticket.show', $ticket->tck_no).'">'. $ticket->tck_no .'</a>';
                })
                ->editColumn('status', function (Ticket $ticket) {
                    return $ticket->status == 1 ? '<span class="badge badge-danger">Otvoren</span >' : '<span class="badge badge-primary">Zatvoren</span >';
                })
                ->editColumn('created_at', function (Ticket $ticket) {
                    return date("d/m/Y", strtotime($ticket->created_at));
                })
                ->editColumn('closed_at', function (Ticket $ticket) {
                    if($ticket->status == 0) {
                        $closed_at = '<small>' . date("d/m/Y", strtotime($ticket->created_at)) . '</small>';
                    } else {
                        $closed_at = '/';
                    }
                    return $closed_at;
                })
                ->addIndexColumn()
                ->rawColumns(['status' => 'status', 'closed_at' => 'closed_at', 'tck_no' => 'tck_no'])
                ->make(true);
            }       
            if(Gate::allows('is-admin')) {
                $tickets = Ticket::with('user')
                ->with('replies')
                ->with('replies.admin');
                return DataTables::of($tickets)
                ->addColumn('replies_no', function (Ticket $ticket) {
                    return count($ticket->replies);
                })
                ->editColumn('tck_no', function (Ticket $ticket) {
                    return '<a href="'.route('ticket.show', $ticket->tck_no).'">'. $ticket->tck_no .'</a>';
                })
                ->editColumn('status', function (Ticket $ticket) {
                    return $ticket->status == 1 ? '<span class="badge badge-danger">Otvoren</span >' : '<span class="badge badge-primary">Zatvoren</span >';
                })
                ->editColumn('created_at', function (Ticket $ticket) {
                    return date("d/m/Y", strtotime($ticket->created_at));
                })
                ->editColumn('description', function (Ticket $ticket) {
                    return (substr($ticket->description, 0, 10) . '...');
                })
                ->editColumn('closed_at', function (Ticket $ticket) {
                    if($ticket->status == 0) {
                        $closed_at = '<small>Tiket je zatvoren <br>' . date("d/m/Y", strtotime($ticket->closed_at)) . '</small>';
                    } elseif(count($ticket->replies) > 0 && $ticket->status == 1) {
                        $closed_at = '<a type="button" class="btn btn-danger" href="'.route('ticket.close', $ticket).'">Zatvori</a>';
                    } else {
                        $closed_at = '<small>Nema dovoljno odgovora za zatvaranje</small>';
                    }
                    return $closed_at;
                })
                ->addIndexColumn()
                ->rawColumns(['status' => 'status', 'closed_at' => 'closed_at', 'tck_no' => 'tck_no'])
                ->make(true);
            }
        }  
    }

    public function check_ticket_status($tck_no, User $user)
    {
        $ticket = Ticket::where(['tck_no' => $tck_no, 'user_id' => $user->id])->first();
        if(!$ticket) {
            return response('Ne postoji tiket sa ovim brojem koji pripada vama!', 500);
        }
        $status = $ticket->status == 1 ? '<span class="badge badge-danger">Otvoren</span >' : '<span class="badge badge-primary">Zatvoren '.strtotime($ticket->closed_at).'</span >';
        $data = '
            <tr>
                <td><a href="'.route('ticket.show', $ticket->tck_no).'">'.$ticket->tck_no.'</a></td>
                <td>'.$ticket->subject.'</td>
                <td>'.substr($ticket->description, 0, 15) . '...'.'</td>
                <td>'.count($ticket->replies).'</td>
                <td>'.strtotime($ticket->created_at).'</td>
                <td>'.$status.'</td>       
            </tr>
        ';
        return response(['ticket' => $data]);
    }
}
