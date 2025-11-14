@extends('layouts.app')

@section('content')
    <div class="card">
        <div
            id="scheduler-root"
            data-logs='@json($logs)'
            data-last-success='@json($lastSuccess)'
            data-last-error='@json($lastError)'
        ></div>
    </div>
@endsection
