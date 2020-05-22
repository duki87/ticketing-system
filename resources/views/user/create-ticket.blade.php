@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Otvori nov tiket') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('ticket.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Predmet</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Unesite predmet tiketa">
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Sadržaj tiketa</label>
                        <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-primary" type="submit">Pošalji</button>
                      </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection