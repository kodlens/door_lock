@extends('layouts.print')

@section('content')
    
    <div class="print-container">
        <div class="p-header">
            <div class="text-header">STUDENT ATTENDANCE</div>
            <div class="text-header">{{ $attendance->ay->ay_desc }}</div>
            <div class="text-header">
                {{ $attendance->schedule->schedule_description }}
                ({{ date('h:s A', strtotime($attendance->schedule->time_start)) }} - 
                {{ date('h:s A', strtotime($attendance->schedule->time_end)) }})
            </div>

        </div>

       

        <div class="table-students">
            <div class="buttons hide-print">
                <button class="button is-primary" onclick="window.print()">
                    <b-icon icon="printer" class="mr-2">
                    </b-icon>
                    Print
                </button>
            </div>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Contact No</th>
                    <th>Remark</th>
                </tr>
                @foreach ($attendance->student_attendance as $std)
                    <tr>
                        <td>{{ $std->student_id }}</td>
                        <td>{{ $std->student_lname }}, {{ $std->student_fname }} {{ $std->student_mname }}</td>
                        <td>{{ $std->student_sex }}</td>
                        <td>{{ $std->student_contact_no }}</td>
                        <td>
                            @if($std->is_present == 1)
                                PRESENT
                            @else
                                ABSENT
                            @endif
                        </td>
                    </tr>
                @endforeach
                
            </table>
        </div>
    </div>



@endsection