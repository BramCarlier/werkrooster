@extends('layouts.app')

@section('content')
    <div class="card">
        <div
            id="settings-root"
            data-settings='@json($settings)'
            data-slack-test-url="{{ route('settings.test-slack') }}"
            data-sms-test-url="{{ route('settings.test-sms') }}"
        ></div>
    </div>
@endsection
