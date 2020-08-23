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
                                            @switch($activity->audienceStatus())
                                                @case(1)
                                                <i class="fas fa-exclamation text-black-50"></i>
                                                @break

                                                @case(2)
                                                <i class="fas fa-hand-paper text-black-50"></i>
                                                @break

                                                @default
                                                <i class="fas fa-question text-black-50"></i>
                                            @endswitch
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
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-sm ml-2 btn-primary" data-toggle="modal" data-target="#exampleModal">
        Aide
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-2">
                <h2 class="text-center">Aide</h2>
                <div class="row">
                    <div class="col-5">
                        <h4>Types d'activités</h4>
                        @foreach($domains as $domain)
                            <div class="{{ $domain->slug }} p-1">{{ $domain->name }}</div>
                        @endforeach
                    </div>
                    <div class="col-6">
                        <h4>Inscriptions</h4>
                        <div class="{{ $domains[0]->slug }} p-1">Activité à laquelle je ne suis ni inscrit ni responsable</div>
                        <div class="{{ $domains[0]->slug }} p-1 myActivities">Activité à laquelle je suis soit inscrit soir responsable</div>
                        <div class="{{ $domains[0]->slug }} p-1">Activité qui a besoin d'inscriptions<i class="fas fa-exclamation text-black-50 float-right"></i></div>
                        <div class="{{ $domains[0]->slug }} p-1">Activité qui accepte encore des inscriptions<i class="fas fa-question text-black-50 float-right"></i></div>
                        <div class="{{ $domains[0]->slug }} p-1">Activité complète<i class="fas fa-hand-paper text-black-50 float-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
