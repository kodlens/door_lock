@extends('layouts.faculty')

@section('content')
    <my-attendance-create
        prop-academic-years='@json($academicYears)'></my-attendance-create>
@endsection