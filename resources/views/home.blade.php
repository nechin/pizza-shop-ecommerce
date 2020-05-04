@extends('layouts.app')

@section('content')
<div id="app" class="container">
    @if (Auth::check())
        <input id="user_token" ref="user_token" type="hidden" value="{{ Auth::user()->api_token }}">
    @endif
    <app></app>
</div>
@endsection
