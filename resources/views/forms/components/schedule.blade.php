@php
$record = $getRecord();
$day = is_array($record->day) ? implode(', ', $record->day) : $record->day; // Convert array to string if needed
$time_start = $record->time_start; // Assuming 'time_start' is a property of the $record object
$time_end = $record->time_end; // Assuming 'time_end' is a property of the $record object
$formattedState = $day . '/' . ' ' . '(' . $time_start . '-' . $time_end . ')';
@endphp

<div>
    {{ $formattedState }}
</div>
