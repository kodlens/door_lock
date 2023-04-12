@extends('layouts.faculty')

@section('content')
    <my-schedule-student-list prop-schedule='@json($schedule)'></my-schedule-student-list>
@endsection

