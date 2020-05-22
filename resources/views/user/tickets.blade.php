@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">              
                <div class="card-header">
                  Vaši tiketi
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">TCK</th>
                                <th scope="col">Predmet</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Odgovori</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($tickets as $key => $ticket)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $ticket['tck_no'] }}</td>
                                    <td>{{ $ticket['subject'] }}</td>
                                    <td>{{ $ticket['description'] }}</td>
                                    <td>{{ count($ticket['replies']) }}</td>
                                    <td>{{ $ticket['created_at'] }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ticket['status'] == 1 ? 'danger' : 'primary' }}">
                                            {{ $ticket['status'] == 1 ? 'Otvoren' : 'Zatvoren' }}
                                        </span >
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection