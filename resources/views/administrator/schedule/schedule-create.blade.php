@extends('layouts.app')

@section('content')

    @if($id > 0)
        <schedule-create 
            prop-academic-years='@json($academicYears)' 
            prop-schedule='@json($schedule)' 
            :prop-id="{{ $id }}">
        </schedule-create>
    @else
        <schedule-create 
            prop-academic-years='@json($academicYears)' 
            prop-schedule='@json($schedule)' 
            :prop-id="0">
        </schedule-create>

    @endif
@endsection

