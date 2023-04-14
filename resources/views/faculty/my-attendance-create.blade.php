@extends('layouts.faculty')

@section('content')
    <my-attendance-create
        prop-academic-year='@json($ay)'
        prop-schedules='@json($schedules)'></my-attendance-create>
@endsection