@extends('layouts.app')

@push('scripts')
    <script src="js/home.js"></script>
@endpush

@section('content')
    <div class="container m-1">
        <table class="table table-bordered w-100">
            <tr>
                <th></th>
                @foreach ($schedArray[array_keys($schedArray)[0]] as $date => $act)
                    <th>{{ \App\Helpers\Helpers::localeDayOfWeek($date) }}<br>{{ \Carbon\Carbon::parse($date)->format('H:i') }}</th>
                @endforeach
            </tr>
            @foreach ($schedArray as $name => $userSched)
                <tr>
                    <th>{{ $name }}</th>
                    @foreach($userSched as $act)
                        @if ($act)
                            <td class="{{ $act->domain->slug }} text-center">
                                <a href="{{ route('activity.show',$act->id) }}" class="text-black-50 text-decoration-none">{{ $act->title }}</a>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endsection
