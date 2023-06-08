@extends('layout.main')

@section('script')
    @vite(['resources/css/projects-list.css'])
@endsection

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <ul>
            @if(count($projects))
                @foreach ($projects as $project)
                    <li class="list-item">
                        <a href="/project/{{$project->id}}" class="list-item-title">{{ $project->title }}</a>
                    </li>
                @endforeach
            @else
                Product list is empty
            @endif
        </ul>
    </div>
@endsection
