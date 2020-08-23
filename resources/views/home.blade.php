@extends('layouts.app')

@push('scripts')
    <script src="js/home.js"></script>
@endpush

@section('content')
    <div class="container m-1">
        <table class="table table-bordered w-100">
            <tr>
                <th>Jour</th>
                @foreach ($timeSlots as $ts)
                    <th>{{ \Carbon\Carbon::parse($ts->from)->format('H:i') }} - {{ \Carbon\Carbon::parse($ts->to)->format('H:i') }}</th>
                @endforeach
            </tr>
            @foreach ($slotsArray as $date => $slots)
                <tr>
                    <th>{{ \App\Helpers\Helpers::localeDayOfWeek($date) }}</th>
                    @foreach($timeSlots as $ts)
                        <td class="text-center">
                            @if (isset($slots[\Carbon\Carbon::parse($ts->from)->format('H:i:s')]))
                                @php $activities = $slots[\Carbon\Carbon::parse($ts->from)->format('H:i:s')]; @endphp
                                @if ($activities->count() > 0)
                                    @foreach ($activities as $activity)
                                        <div class="{{ $activity->domain->slug }} {{ $activity->hasUser(Auth::user()) ? 'myActivities' : 'notMyActivities' }}" title="{{ $activity->description }}. Lieu: {{ $activity->location }}, min {{ $activity->minparticipants }}pers., max {{ $activity->maxparticipants }}">
                                            <a href="{{ route('activity.show',$activity->id) }}" class="text-black-50 text-decoration-none">{{ $activity->title }}</a>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endsection
