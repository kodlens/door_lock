@extends('layouts.print-css')

@section('custom-css')
    <style>

        @page{
            size: 8.5 13in
        }

        .print-container{
            margin: 10px 0 0 0;
            padding: 0;
        }

        .log-table{
            margin: 10px auto;
            padding: 10px;
            font-size: .7em;
        }

        .log-table tr th{
            padding: 8px;
            /* border: 1px solid red; */
            border: 1px solid rgb(180, 180, 180);

        }
        .log-table tr td{
            padding: 5px;
            border: 1px solid rgb(180, 180, 180);
        }

        .hide-print{
            width: inherit;
        }

        
        @media print {

            .print-container{
                margin: 0;
                padding: 0;
            }

            .hide-print{
                display: none;
            }
            
            .print-table {
                page-break-inside: avoid;
            }

           
        }

    </style>
@endsection

@section('content')
    
    
    <div class="print-container">

        <div style="text-align: center; font-weight:bold;">
            FACULTY ATTENDANCE
        </div>
        <div style="text-align: center;">
            <span style="font-weight: bold;">FROM: {{ $start }} - {{ $end }} </span>
        </div>

        <div>
            <table class="log-table">
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Schedule</th>
                    <th>Door</th>
                    <th>Date Time Logs</th>
                </tr>

            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['user_name'] }}</td>
                    <td>{{ $item['role'] }}</td>
                    <td>{{ $item['schedule']->schedule_description }} 
                        ({{ date('h:i A', strtotime($item['schedule']->time_start)) }} - {{ date('h:i A', strtotime($item['schedule']->time_end)) }})
                        (
                            @if($item['schedule']->mon == 1)
                                M
                            @endif
                            @if($item['schedule']->tue == 1)
                                T
                            @endif
                            @if($item['schedule']->wed == 1)
                                W
                            @endif
                            @if($item['schedule']->thu == 1)
                                TH
                            @endif
                            @if($item['schedule']->fri == 1)
                                F
                            @endif
                            @if($item['schedule']->sat == 1)
                                SAT
                            @endif
                            @if($item['schedule']->sun == 1)
                                SUN
                            @endif
                        )
                    </td>
                    <td>{{ $item['door']->door_name }} ({{ $item['door']->mac_add }})</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
            </table>

            <div class="buttons hide-print is-centered">
                <button class="button is-primary" onclick="window.print()">
                    <b-icon icon="printer" class="mr-2">
                    </b-icon>
                    Print
                </button>
            </div>
        </div>
           
        
    </div>

@endsection