@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Tiket: {{ $ticket->tck_no }}</div>
                <div class="card-body">
                    <h2 class="d-inline">Podaci o tiketu</h2>
                    <div class="d-inline float-right">
                        @if(count($ticket['replies']) > 0 && $ticket['status'] == 1)
                            <a type="button" class="btn btn-danger" href="{{ route('ticket.close', ['ticket' => $ticket]) }}">Zatvori</a>
                        @elseif($ticket['status'] == 0)
                            <small>Tiket zatvoren {{ $ticket->closed_at }}</small>
                        @else
                            <small>Nema dovoljno odgovora za zatvaranje</small>
                        @endif
                    </div>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Otvorio korisnik: 
                            <span class="float-right">
                                {{ $ticket->user->name }}
                                <small>({{ $ticket->user->email }})</small>
                            </span>
                        </li>
                        <li class="list-group-item">Predmet: 
                            <span class="float-right">
                                {{ $ticket->subject }}
                            </span>
                        </li>
                        <li class="list-group-item">Opis: 
                            <span class="float-right">
                                {{ $ticket->description }}
                            </span>
                        </li>
                        <li class="list-group-item">Status: 
                            <span class="float-right badge badge-{{ $ticket['status'] == 1 ? 'danger' : 'primary' }}">
                                {{ $ticket->status == 1 ? 'Otvoren' : 'Zatvoren' }}
                            </span >
                        </li>
                        <li class="list-group-item">Broj odgovora: 
                            <span class="float-right">
                                {{ count($ticket['replies']) }}
                            </span >
                        </li>
                        <li class="list-group-item">Datum kreiranja: 
                            <span class="float-right">
                                {{ date("d/m/Y H:i", strtotime($ticket['created_at'])) }}
                            </span>
                        </li>
                        <li class="list-group-item">Datum zatvaranja: 
                            <span class="float-right">
                                {{ $ticket['closed_at'] == null ? '/' : date("d/m/Y H:i", strtotime($ticket['closed_at'])) }}
                            </span>
                        </li>
                    </ul>
                    @if(count($ticket['replies']) > 0)
                        <div>
                            <h2>Odgovori</h2>
                            <hr>
                            <ul class="list-unstyled">
                                @foreach($ticket['replies'] as $reply)
                                    <li class="media rounded bg-{{ $reply['admin'] == null ? 'light' : 'secondary text-white' }} p-2 mb-2">
                                        <div class="media-body">
                                        <h5 class="mt-0 mb-1">
                                            Odgovorio: {{ $reply['admin'] == null ? $ticket->user->name : $reply->admin->name }}
                                            <small class="float-right">{{ date("d/m/Y H:i", strtotime($reply['created_at'])) }}</small>
                                        </h5>
                                        {{ $reply['reply'] }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($ticket['status'] == 1)
                        <div>
                            <h2>Dodaj odgovor</h2>
                            <hr>
                            <x-reply :ticket="$ticket" :errors="$errors ?? ''" />
                        </div>
                    @else 
                        <h2 class="text-muted">Tiket je zatvoren i nije moguće dodavati odgovore.</h2>
                    @endif  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection