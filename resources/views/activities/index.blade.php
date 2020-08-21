@extends('layouts.app')

@section('content')
    <div class="container m-1">
        @foreach($domains as $domain)
            <h3>{{ $domain->name }}</h3>
            @foreach($domain->activities as $activity)
                <div class="row m-1">
                    {{ $activity->description }}, {{ $activity->location }}, {{ $activity->minparticipants }}-{{ $activity->minparticipants }} p., {{ \Carbon\Carbon::parse($activity->slot->date)->format('D') }} {{ \Carbon\Carbon::parse($activity->slot->timeslot->from)->format('H:i') }}
                    <form method="post" action="activity/{{ $activity->id }}">@csrf @method('DELETE') <input type="submit" class="btn btn-sm btn-danger ml-3" value="-"></form>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection
