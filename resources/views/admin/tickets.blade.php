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
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
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
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('tickets/load') }}",
           columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'tck_no', name: 'tck_no' },
                    { data: 'subject', name: 'subject', searchable: true },
                    { data: 'description', name: 'description', orderable: false, searchable: false },
                    { data: 'replies_no', name: 'replies_no' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },        
                    { data: 'closed_at', name: 'closed_at' }
                 ]
        });
  });
</script>
@endsection