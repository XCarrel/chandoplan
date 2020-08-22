<div class="container mt-4 table-responsive text-center">
    <div class="jumbotron pt-2 pb-2">
        <div class="form-row">
            <label class="form-control bg-transparent col-2 border-0 text-right">Description</label>
            <input type="text" name="description" class="form-control col-6" value="{{ $act->description }}" required>
        </div>
        <div class="form-row">
            <label class="form-control bg-transparent col-2 border-0 text-right">Lieu</label>
            <input type="text" name="location" class="form-control col-6" value="{{ $act->location }}" required>
        </div>
        <div class="form-row">
            <label class="form-control bg-transparent col-2 border-0 text-right">Jour</label>
            <select name="day" class="form-control col-2">
                @foreach($slots as $slot)
                    <option value="{{ $slot->date }}" {{ $act->slot ? ($act->slot->date == $slot->date ? 'selected' : '') : '' }}>{{ \App\Helpers\Helpers::localeDayOfWeek($slot->date) }}</option>
                @endforeach
            </select>
            <label class="form-control bg-transparent col-2 border-0 text-right">Période</label>
            <select name="timeslot" class="form-control col-2">
                @foreach($timeslots as $timeslot)
                    <option value="{{ $timeslot->id }}" {{ $act->slot ? ($act->slot->timeslot->id == $timeslot->id ? 'selected' : '') : '' }}>{{ Carbon\Carbon::parse($timeslot->from)->format('H:i') }} - {{ Carbon\Carbon::parse($timeslot->to)->format('H:i') }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label class="form-control bg-transparent col-2 border-0 text-right">Type</label>
            <select name="domain" class="form-control col-2">
                @foreach($domains as $domain)
                    <option value="{{$domain->id}}" {{ $act->domain ? ($act->domain->id == $domain->id ? 'selected' : '') : '' }}>{{ $domain->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label class="form-control bg-transparent col-2 border-0 text-right">Participants: minimum </label>
            <input type="number" name="minp" class="form-control col-1" value="{{ $act->minparticipants }}">
            <label class="form-control bg-transparent col-1 border-0 text-right"> maximum </label>
            <input type="number" name="maxp" class="form-control col-1" value="{{ $act->maxparticipants }}">
        </div>

    </div>
</div>
