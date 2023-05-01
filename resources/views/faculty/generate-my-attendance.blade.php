@extends('layouts.print-css')

@section('content')
    
    
    <div class="print-container">

        <div>

        </div>



       
        @php

            $date = new DateTime($start_date); // Create a new DateTime object for the start date

            //$data = json_encode($attendances, true);

            $data = json_decode($attendances, true);


            $at = array_filter($data, function($att) {
                return $att->schedule_id == 1;
            });

            echo $at['schedule_id'];

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
                            <td>';


                                echo
                                '</td>
                        </tr>';
                }
                
                $date->add(new DateInterval('P1D')); // Increment the date by one day
                echo '</table><br>';
                
            }

        @endphp
           
        
    </div>

@endsection