
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
      Sortiraj
      Po datumu unosa
      <select class="form-control">
        <option>Po datumu unosa - prvo noviji</option>
        <option>Po datumu unosa - prvo stariji</option>
      </select>
      Po statusu
      <select class="form-control">
        <option>Otvoreni</option>
        <option>Zatvoreni</option>
      </select>
      <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TCK</th>
              <th scope="col">Datum kreiranja</th>
              <th scope="col">Status</th>
              <th scope="col">Opis</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>Otto</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
              <td>Otto</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
              <td>@twitter</td>
              <td>Otto</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
              <td>@twitter</td>
              <td>Otto</td>
            </tr>
          </tbody>
        </table>
  </div>
</div>