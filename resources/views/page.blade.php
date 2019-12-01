@extends('layouts.app')

@section('meta')
    <meta name="description" content="{{ $page[0]->description }}">
@endsection

@section('content')
    <h1 class="mb-3">{{ $page[0]->title }}</h1>
    @if ($page[0]->descendants->first())
        <h3>Children of {{$page[0]->title}}</h3>
        <ul class="list-unstyled">
            @foreach ($page[0]->descendants as $child)
                <li><a href="{{ route('page', ['id'=>$child['id']]) }}">{{ $child->title }}</a></li>
            @endforeach
        </ul>
    @endif

    {!! clean($page[0]->content) !!}
@endsection
