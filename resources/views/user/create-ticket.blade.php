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
                    <label for="subject">Predmet</label>
                    <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required autocomplete="subject" placeholder="Unesite predmet tiketa" autofocus>
                    @error('subject')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="description">Sadržaj tiketa</label>
                    <textarea class="form-control @error('subject') is-invalid @enderror" name="description" id="description" required autocomplete="subject" cols="30" rows="10">{{ old('description') }}</textarea>
                    @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
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