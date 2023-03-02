@extends('layouts.app')

@section('content')
    <schedule-create prop-academic-years='@json($academicYears)'></schedule-create>
@endsection

