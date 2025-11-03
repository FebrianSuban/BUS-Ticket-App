@extends('layouts.app')

@section('content')
@auth
    @if(auth()->user()->isAdmin())
        @include('home.admin')
    @else
        @include('home.user')
    @endif
@else
    @include('home.user')
@endauth
@endsection
