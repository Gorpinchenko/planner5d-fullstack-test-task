@extends('layout.main')

@section('script')
    @vite(['resources/css/app.css', 'resources/js/projects-list.ts'])
@endsection

@section('content')
    <div id="page">projects-list</div>
@endsection
