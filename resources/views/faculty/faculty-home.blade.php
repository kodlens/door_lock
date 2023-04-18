@extends('layouts.faculty')

@section('content')
    <faculty-home   
        prop-user='@json($user)'
        prop-schedules='@json($schedules)'
        prop-ay='@json($ay)'
    ></faculty-home>
@endsection