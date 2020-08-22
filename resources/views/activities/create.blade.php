@extends('layouts.app')

@section('content')
    <div class="container m-1">
        <h2>Nouvelle activité</h2>
        <form method="post" action="{{ route('activity.store') }}">
            @csrf
            @include('activities._formfields')
            <div class="form-row justify-content-center">
                <input type="submit" class="btn btn-primary" value="Créer">
            </div>
        </form>
    </div>
@endsection
