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
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TCK</th>
              <th scope="col">Datum kreiranja</th>
              <th scope="col">Status</th>
              <th scope="col">Predmet</th>
              <th scope="col">Opis</th>
              <th scope="col">Odgovori</th>
            </tr>
          </thead>
          <tbody>
            @foreach($attributes as $key => $ticket)
              <tr>
              <th scope="row">{{ $ticket['id'] }}</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
</div>