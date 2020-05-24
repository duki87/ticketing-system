<form method="POST" action="{{ route('reply.store', ['ticket' => $ticket]) }}">
    @csrf
    <div class="form-group">
        <label for="reply">Sadržaj odgovora</label>
        <textarea class="form-control @error('reply') is-invalid @enderror" required autocomplete="reply" name="reply" id="reply" cols="30" rows="10">{{ old('reply') }}</textarea>
        @error('reply')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Dodaj odgovor</button>
    </div>
</form>