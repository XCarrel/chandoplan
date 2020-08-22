@extends('layouts.app')

@section('content')
    <div class="container m-1">
        <h2>Modification d'activité</h2>
        <form method="post" action="{{ route('activity.update',$act->id) }}">
            @method('PUT')
            @csrf
            @include('activities._formfields')
            <div class="form-row justify-content-center">
                <input type="submit" class="btn btn-primary" value="Enregistrer">
            </div>
        </form>
    </div>
@endsection
