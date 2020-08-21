@extends('layouts.app')

@section('content')
    <div class="container m-1">
        @foreach($domains as $domain)
            <h3>{{ $domain->name }}</h3>
            @foreach($domain->activities as $activity)
                <p>{{ $activity->description }}, {{ $activity->location }}, {{ $activity->minparticipants }}-{{ $activity->minparticipants }} p., {{ \Carbon\Carbon::parse($activity->slot->date)->format('D') }} {{ \Carbon\Carbon::parse($activity->slot->timeslot->from)->format('H:i') }}</p>
            @endforeach
        @endforeach
    </div>
@endsection
