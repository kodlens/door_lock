@extends('layouts.faculty')

@section('content')
    <my-profile
        prop-user='@json($user)'></my-profile>
@endsection

