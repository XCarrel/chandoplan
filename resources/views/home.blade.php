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
                <th>Jour</th>
                @foreach ($allSlots as $ts)
                    <th>{{ \Carbon\Carbon::parse($ts->from)->format('H:i') }} - {{ \Carbon\Carbon::parse($ts->to)->format('H:i') }}</th>
                @endforeach
            </tr>
            @foreach ($slotsArray as $date => $slots)
                <tr>
                    <th>{{ Carbon\Carbon::parse($date)->format('D') }}</th>
                    @foreach($allSlots as $slot)
                        @if (isset($slots[\Carbon\Carbon::parse($slot->from)->format('H:i:s')]))
                            <td class="text-center">X</td>
                        @else
                            <td>&nbsp;</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endsection
