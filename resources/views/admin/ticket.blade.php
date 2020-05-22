@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Tiket: {{ $ticket['tck_no'] }}</div>
                <div class="card-body">
                    <h2 class="d-inline">Podaci o tiketu</h2>
                    @if(count($ticket['replies']) > 0)
                        <button class="btn btn-danger d-inline float-right">Zatvori tiket</button>
                    @endif
                        <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Otvorio korisnik: 
                            <span class="float-right">
                                {{ $ticket['user']['name'] }}
                                <small>({{ $ticket['user']['email'] }})</small>
                            </span>
                        </li>
                        <li class="list-group-item">Predmet: 
                            <span class="float-right">
                                {{ $ticket['subject'] }}
                            </span>
                        </li>
                        <li class="list-group-item">Opis: 
                            <span class="float-right">
                                {{ $ticket['description'] }}
                            </span>
                        </li>
                        <li class="list-group-item">Status: 
                            <span class="float-right badge badge-{{ $ticket['status'] == 1 ? 'danger' : 'primary' }}">
                                {{ $ticket['status'] == 1 ? 'Otvoren' : 'Zatvoren' }}
                            </span >
                        </li>
                        <li class="list-group-item">Broj odgovora: 
                            <span class="float-right">
                                {{ count($ticket['replies']) }}
                            </span >
                        </li>
                        <li class="list-group-item">Datum kreiranja: 
                            <span class="float-right">
                                {{ $ticket['created_at'] }}
                            </span>
                        </li>
                        <li class="list-group-item">Datum zatvaranja: 
                            <span class="float-right">
                                {{ $ticket['closed_at'] == null ? '/' : $ticket['closed_at'] }}
                            </span>
                        </li>
                    </ul>
                    @if(count($ticket['replies']) > 0)
                        <div>
                            <h2>Odgovori</h2>
                            <hr>
                            <ul class="list-unstyled">
                                @foreach($ticket['replies'] as $reply)
                                    <li class="media bg-light p-2 mb-2">
                                        <div class="media-body">
                                        <h5 class="mt-0 mb-1">
                                            Odgovorio: {{ $reply['admin']['name'] }}
                                            <small class="float-right">{{ $reply['created_at'] }}</small>
                                        </h5>
                                        {{ $reply['reply'] }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h2>Dodaj odgovor</h2>
                    <hr>
                    <form method="POST" action="{{ route('reply.store', ['ticket' => $ticket]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Sadržaj odgovora</label>
                                <textarea class="form-control" name="reply" id="" cols="30" rows="10"></textarea>
                            </div>
                            <input type="hidden" name="ticket_id" value="{{ $ticket['id'] }}">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Dodaj odgovor</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection