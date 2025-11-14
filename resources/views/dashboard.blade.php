<?php
@extends('layouts.app')

@section('content')
    <div class="card">
        <div
            id="dashboard-root"
            data-upcoming='@json($upcoming)'
        ></div>
    </div>
@endsection
