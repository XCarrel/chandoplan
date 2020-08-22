@extends('layouts.app')

@section('content')
    <div class="container m-1">
        <h2>Activité: {{ $act->description }} ({{ $act->domain->name }})</h2>
        <div class="container mt-4 table-responsive text-center">
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Description</label>
                <label class="form-control bg-transparent col-8 text-left">{{ $act->description }}</label>
            </div>
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Lieu</label>
                <label class="form-control bg-transparent col-8 text-left">{{ $act->location }}</label>
            </div>
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Jour</label>
                <label class="form-control bg-transparent col-3 text-left">{{ \App\Helpers\Helpers::localeDayOfWeek($act->slot->date) }}</label>
                <label class="form-control bg-transparent col-2 border-0 text-right">Période</label>
                <label class="form-control bg-transparent col-3 text-left">{{ Carbon\Carbon::parse($act->slot->timeslot->from)->format('H:i') }} - {{ Carbon\Carbon::parse($act->slot->timeslot->to)->format('H:i') }}</label>
            </div>
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Responsable</label>
                <label class="form-control bg-transparent col-8 text-left">{{ $act->responsible->name }}</label>
            </div>
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Participants</label>
                <label class="d-inline-block form-control bg-transparent col-8 text-left" rows="5">
                    @if ($act->users()->count() > 0)
                        {{ implode(', ',$act->users()->pluck('name')->toArray()) }}
                    @else
                        Aucun pour le moment.
                    @endif
                    (minimum {{ $act->minparticipants }}, maximum {{ $act->maxparticipants }})
                </label>
            </div>
        </div>
        @if ($act->hasUser(Auth::user()))
            @if($act->users()->count() > $act->minparticipants)
                <form method="post" action="{{ route('activity.unsubscribe',$act->id) }}">
                    @csrf
                    <div class="form-row justify-content-center">
                        <input type="submit" class="btn btn-primary" value="Je me désinscris">
                    </div>
                </form>
            @else
                <div class="form-row justify-content-center">
                    Désolé, la désinscription n'est pas possible
                </div>
            @endif
        @else
            @if($act->users()->count() < $act->maxparticipants)
                <form method="post" action="{{ route('activity.subscribe',$act->id) }}">
                    @csrf
                    <div class="form-row justify-content-center">
                        <input type="submit" class="btn btn-primary" value="Je m'inscris!">
                    </div>
                </form>
            @else
                <div class="form-row justify-content-center">
                    Désolé, cette activité est complète
                </div>
            @endif
        @endif
    </div>
@endsection
