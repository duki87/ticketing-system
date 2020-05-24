<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
use Gate;
use Illuminate\Support\Facades\Validator;

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
    public function index()
    {
        if(Gate::allows('is-user')) {
            return view('user.tickets');
        }
        if(Gate::allows('is-admin')) {
            return view('admin.tickets');
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
        $request->validate([
            'subject' => ['required', 'string', 'min:5'],
            'description' => ['required', 'string', 'max:255']
        ]);
        if(Gate::allows('is-user')) {
            $ticket = new Ticket([
                'tck_no' => $this->generate_tck_no(),
                'user_id' => Auth::id(),
                'subject' => $request->subject,
                'description' => $request->description
            ]);
            if($ticket->save()) {
                return redirect('/home')->with(['type' => 'success', 'msg' => 'Uspešno ste otvorili tiket.']);
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
        if(Gate::allows('is-admin')) {
            $tickets_opened_m = Ticket::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->get();
            $tickets_closed_m = Ticket::where('closed_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->get();
            $data1 = [];
            $data2 = array();
            for($i=1; $i<date('t'); $i++) {
                $day_o = [];
                $day_c = [];
                $tickets_opened = 0;
                $tickets_closed = 0;
                $day_o['label'] = $i;
                $day_c['label'] = $i;
                foreach($tickets_opened_m as $ticket) {
                    if((int)(Carbon::parse($ticket->created_at)->format('d')) == $i) {
                        $tickets_opened++;
                    }
                }
                foreach($tickets_closed_m as $ticket) {
                    if((int)(Carbon::parse($ticket->closed_at)->format('d')) == $i) {
                        $tickets_closed++;
                    }
                }
                $day_o['y'] = $tickets_opened;
                $day_c['y'] = $tickets_closed;
                $data1[] = $day_o;
                $data2[] = $day_c;
            }
            return view('admin.statistics')->with(['tickets_opened' => $data1, 'tickets_closed' => $data2]);
        }
    }  

    public function load(Request $request)
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
                    return '<a href="'.route('ticket.show', $ticket).'">'. $ticket->tck_no .'</a>';
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
                    return '<a href="'.route('ticket.show', $ticket).'">'. $ticket->tck_no .'</a>';
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

    public function close(Ticket $ticket)
    {
        if(Gate::allows('is-admin')) {
            if(count($ticket->admin_replies) > 0) {
                $ticket->update([
                    'status' => $ticket->status == 0,
                    'closed_at' => Carbon::now()->toDateTimeString()
                ]);
            }
        }
        return redirect('/home')->with(['type' => 'success', 'msg' => 'Uspešno ste zatvorili tiket.']);
    }

    private function generate_tck_no()
    {
        $last_inserted = Ticket::orderBy('created_at', 'desc')->first();
        if(!$last_inserted) {
            return '000001';
        }
        $last_code = $last_inserted['tck_no'];
        (int)$last_code++;
        $last_code = sprintf("%06s", $last_code);
        return (string)$last_code;
    }
}
