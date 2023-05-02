@extends('layouts.print-css')

@section('content')
    
    
    <div class="print-container">

        <div style="text-align: center; font-weight:bold;">
            FACULTY ATTENDANCE
        </div>
        <div style="text-align: center;">
            @if (isset($attendances[0]->user_name))
                {{ $attendances[0]->user_name }}
            @endif
        </div>

        @php

            $date = new DateTime($start_date); // Create a new DateTime object for the start date
            while ($date <= new DateTime($end_date)) { // Loop until the date is greater than the end date
            
                echo '<table class="att-table">';
                echo '<tr><td colspan="3"><strong>DATE: </strong>'. $date->format('Y-M-d') . '</td></tr>';
                echo '<tr>
                        <th>Schedule Description</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>';
                foreach($schedules as $sched){ 
                    echo '
                        <tr>
                            <td>'. $sched->schedule_description.'</td>
                            <td>'. date('h:i A', strtotime($sched->time_start)) . ' - ' . date('h:i A',strtotime($sched->time_end)) . '</td>
                            <td style="width: 100px;">';
                                $flag = 0;
                                foreach ($attendances as $att) {
                                    if($sched->schedule_id == $att->schedule_id && $date == new DateTime($att->attendance_date)){
                                        $flag = 1;
                                        break;
                                    }
                                }

                                if($flag > 0){
                                    echo 'PRESENT';
                                }else{
                                    echo '';
                                }

                    //echo the end tag of td and tr
                    echo
                                '</td>
                        </tr>';
                }
                
                $date->add(new DateInterval('P1D')); // Increment the date by one day
                echo '</table>';
                
            }

        @endphp
           
        
    </div>

@endsection