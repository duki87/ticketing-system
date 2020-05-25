@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">              
                <div class="card-header">
                  Proveri status tiketa
                </div>
                <div class="card-body">
                    <div>
                        <h5>Unesite TCK broj tiketa</h5>
                        <form class="form-inline" id="check-status" style="width:auto">
                            <input id="user" type="hidden" value="{{ Auth::id() }}">
                            <input id="tck_no" type="text" style="width:40%" class="form-control mb-2 mr-sm-2" placeholder="TCK broj treba da sadrži 6 cifara">                            
                            <button type="submit" class="btn btn-primary mb-2">Proveri</button>
                        </form>
                        <p id="error" class="text-danger"></p>
                    </div>
                    <table id="table" class="table table-striped d-none">
                        <thead>
                            <tr>
                                <th scope="col">TCK</th>
                                <th scope="col">Predmet</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Odgovori</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    $(document).on('submit', '#check-status', function(e) {
        e.preventDefault();
        $('#table').addClass('d-none');
        $('#tbody').html('');
        $('#error').html('');
        var tck_no = $('#tck_no').val();
        var user = $('#user').val();
        if(tck_no == '') {
            $('#error').append('<span>Morati uneti broj tiketa u ispravnom formatu!</span>');
            return false;
        }
        $.ajax({
            beforeSend: function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
            },
            url: '/api/tickets/'+tck_no+'/'+user+'/status',
            type: 'GET',
            success: function (data) { 
                $('#table').removeClass('d-none');
                $('#tbody').append(data.ticket);
            },
            error: function(xhr, statusText, err){
                if(xhr.status === 500) {
                    console.log(err);
                    console.log(statusText);
                    $('#error').append(statusText);
                } 
            }
        }); 
    });
  });
</script>
@endsection