@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">              
                <div class="card-header">
                  Pregled tiketa
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-inline float-right" method="GET">
                      @csrf
                      <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sortiraj po datumu</label>
                      <select class="form-control custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                        <option value="desc" selected>Prvo noviji</option>
                        <option value="asc" selected>Prvo stariji</option>
                      </select>
                      <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sortiraj po statusu</label>
                      <select class="form-control custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                        <option value="desc" selected>Prvo otvoreni</option>
                        <option value="asc" selected>Prvo zatvoreni</option>
                      </select>
                      <button type="submit" class="btn btn-primary">Primeni</button>
                    </form>
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
                              <th scope="col">Zatvori</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($tickets as $key => $ticket)
                              <tr>
                                  <th scope="row">{{ ++$key }}</th>
                                  <td>
                                    <a href="{{ route('ticket.show', ['ticket' => $ticket]) }}">
                                      {{ $ticket['tck_no'] }}
                                    </a>
                                  </td>
                                  <td>{{ $ticket['subject'] }}</td>
                                  <td>{{ $ticket['description'] }}</td>
                                  <td>{{ count($ticket['replies']) }}</td>
                                  <td>{{ $ticket['created_at'] }}</td>
                                  <td>
                                      <span class="badge badge-{{ $ticket['status'] == 1 ? 'danger' : 'primary' }}">
                                          {{ $ticket['status'] == 1 ? 'Otvoren' : 'Zatvoren' }}
                                      </span >
                                  </td>
                                  <td>
                                    @if(count($ticket['replies']) > 0 && $ticket['status'] == 1)
                                      <form action="{{ route('ticket.update', ['ticket' => $ticket]) }}" method="POST">
                                        <input type="hidden" name="_method" value="PUT"> 
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Zatvori</button>
                                      </form>
                                    @elseif($ticket['status'] == 0)
                                      <small>Tiket zatvoren {{ $ticket['closed_at'] }}</small>
                                    @else
                                      <small>Nema dovoljno odgovora za zatvaranje</small>
                                    @endif
                                  </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div class="pagination">
                          {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection