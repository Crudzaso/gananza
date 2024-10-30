@extends('audit::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('audit.name') !!}</p>
@endsection
