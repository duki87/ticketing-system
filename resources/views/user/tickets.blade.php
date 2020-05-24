@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">              
              <div class="card-header">
                Tiketi korisnika: {{ Auth::user()->name }}
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
                            <th scope="col">Status</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum zatvaranja</th>                     
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
            language: {
                "sProcessing": "Učitava se...",
                "sLengthMenu": "Prikaži _MENU_ tiketa po strani",
                "sZeroRecords": "Nije pronađen nijedan rezultat.",
                "sEmptyTable": "Trenutno nema nijednog tiketa.",
                "sInfo": "Prikazano _START_ do _END_ od ukupno _TOTAL_ tiketa",
                "sInfoEmpty": "Prikazano je 0 od 0 od ukupno 0 tiketa",
                "sInfoFiltered": "(fitrirano od ukupno _MAX_ tiketa)",
                "sInfoPostFix": "",
                "sSearch": "Pretraga:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Učitava se...",
                "oPaginate": {
                  "sFirst": "Prva",
                  "sLast": "Poslednja",
                  "sNext": "Sledeća",
                  "sPrevious": "Prethodna"
                },
                "oAria": {
                  "sSortAscending": ": Sortiraj rastuće",
                  "sSortDescending": ": Sortiraj opadajuće"
              }
          },
          processing: true,
          serverSide: true,
          ajax: "{{ url('tickets/load') }}",
          columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false },
                  { data: 'tck_no', name: 'tck_no' },
                  { data: 'subject', name: 'subject', searchable: true },
                  { data: 'description', name: 'description', orderable: false, searchable: false },
                  { data: 'replies_no', name: 'replies_no' },
                  { data: 'status', name: 'status' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'closed_at', name: 'closed_at' }
                ]
      });
  });
</script>
@endsection