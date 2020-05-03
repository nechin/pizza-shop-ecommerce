@extends('layouts.app')

@section('content')
<div id="app" class="container">
    @if (Auth::check())
        <input id="user_is_auth" ref="user_is_auth" type="hidden" value="{{ Auth::user()->id }}">
    @endif
    <app></app>
</div>
@endsection
