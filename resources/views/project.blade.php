@extends('layout.main')

@section('script')
    @vite(['resources/css/app.css', 'resources/js/project.ts'])
@endsection

@section('content')
    <div id="page">project</div>
@endsection
