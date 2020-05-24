@if($message = Session::has('msg') && $type = Session::has('type'))
    <div class="container">
        <div class="col-md-12 mt-2 mb-2">
            <div class="alert alert-{{ Session::get('type') }}">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ Session::get('msg') }}</strong>
            </div>
        </div>
    </div>
@endif