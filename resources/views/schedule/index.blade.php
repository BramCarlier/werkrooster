@extends('layouts.app')

@section('content')
    <div class="card">
        <div
            id="schedule-root"
            data-schedule='@json($schedule)'
        ></div>
    </div>
@endsection
