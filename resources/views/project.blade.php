@extends('layout.main')

@section('script')
    @vite(['resources/css/project-page.css'])
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h1>
                {{ $project->title }}
            </h1>
            <div class="statistics">Hits: {{ $hits }}</div>
        </div>
        <object
                class="canvas"
                data="{{ $project->canvas_link }}"
                type="text/html"
                width="100%"
                height="400"
        ></object>
    </div>
@endsection
