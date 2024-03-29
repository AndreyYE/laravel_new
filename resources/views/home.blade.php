@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
<div class="row">
    @if(Auth::check())
        <div class="col">
            <a href="{{route('cabinet.adverts.create')}}" class="btn btn-success mb-1">Add Advert</a>
        </div>
    @endif
</div>
    <div class="card card-default mb-3">
        <div class="card-header">
            All Categories
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($categories, 3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $current)
                                <li><a href="{{ route('adverts.index', ['region'=>null, 'category'=>$current]) }}">{{ $current->name }}</a></li>
{{--                                {{$current->name}}--}}
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-default mb-3">
        <div class="card-header">
            All Regions
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($regions, 3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $current)
                                <li><a href="{{ route('adverts.index', ['region'=>$current, 'category'=>null]) }}">{{ $current->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
