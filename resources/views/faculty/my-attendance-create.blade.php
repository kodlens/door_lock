@extends('layouts.faculty')

@section('content')
    <my-attendance-create
        prop-academic-year='@json($ay)'
        prop-schedules='@json($schedules)'
        prop-attendance='@json($attendance)'
        :prop-is-update="{{ $isUpdate }}"></my-attendance-create>
@endsection