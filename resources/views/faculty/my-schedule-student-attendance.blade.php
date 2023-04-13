@extends('layouts.faculty')

@section('content')
    <my-schedule-student-attendance prop-schedule='@json($schedule)'></my-schedule-student-attendance>
@endsection