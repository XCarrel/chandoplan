@extends('layouts.app')

@section('content')
    <div class="container m-1">
        <h2>Activité: {{ $act->title }} ({{ $act->domain->name }})</h2>
        <div class="container mt-4 table-responsive text-center">
            <div class="form-row">
                <label class="form-control bg-transparent col-2 border-0 text-right">Description</label>
                <textarea rows="10" disabled class="form-control bg-transparent col-8 text-left">{{ $act->description }}</textarea>
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
                <textarea rows="2" disabled class="form-control bg-transparent col-8">
                    @if ($act->users()->count() > 0)
                        {{ implode(', ',$act->users()->pluck('name')->toArray()) }}
                    @else
                        Aucun pour le moment.
                    @endif
(minimum {{ $act->minparticipants }}, maximum {{ $act->maxparticipants }})
                </textarea>
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
                @if (\App\User::find(Auth::user()->id)->isFree($act->slot))
                    <form method="post" action="{{ route('activity.subscribe',$act->id) }}">
                        @csrf
                        <div class="form-row justify-content-center">
                            <input type="submit" class="btn btn-primary" value="Je m'inscris!">
                        </div>
                    </form>
                @else
                    <div class="form-row justify-content-center">
                        Vous avez autre chose de prévu à ce moment-là
                    </div>
                @endif
            @else
                <div class="form-row justify-content-center">
                    Désolé, cette activité est complète
                </div>
            @endif
        @endif
        @if(Auth::user()->level > 0 || Auth::user()->id == $act->responsible->id)
            <div class="row">
                <a class="btn btn-primary ml-2" href="{{ route('activity.edit',$act->id) }}">Modifier</a>
                <form method="post" action="{{ route('activity.destroy',$act->id) }}">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger ml-3">Supprimer</button>
                </form>
            </div>
        @endif
    </div>
@endsection
