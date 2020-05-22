@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(Auth::user()->role() === 'admin')
            <x-admin-tickets :tickets="$tickets" />
        @else 
            <x-user-tickets :tickets="$tickets" />
        @endif
        </div>
    </div>
</div>
@endsection
