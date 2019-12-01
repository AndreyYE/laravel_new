@extends('layouts.app')

@section('content')
    <div class="d-flex flex-row mb-3 justify-content-around">
        <a href="{{ route('admin.regions.create',['parent'=>$region->id]) }}" class="btn btn-success mr-1">Add Region</a>

        <a href="{{ route('admin.regions.edit', $region) }}" class="btn btn-primary mr-1">Edit</a>

        <form method="POST" action="{{ route('admin.regions.destroy', $region) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $region->id }}</td>
        </tr>
        <tr>
            <th>Region</th><td>{{ $region->name }}</td>
        </tr>
        <tr>
            <th>Slug</th><td>{{ $region->slug }}</td>
        </tr>
        <tr>
            <th>Parent</th>
            <td>{{$region->parent ? $region->parent->name : 'It is a main region'}}</td>
        </tr>
        </tbody>
    </table>
@include('admin.regions._list')
@endsection
