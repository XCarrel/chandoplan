@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <table class="table table-bordered">
            <tr>
                @foreach ($timeslots as $ts)
                    <th>{{ \Carbon\Carbon::parse($ts->from)->format('H:i') }} - {{ \Carbon\Carbon::parse($ts->to)->format('H:i') }}</th>
                @endforeach
            </tr>
        </table>
    </div>
@endsection
