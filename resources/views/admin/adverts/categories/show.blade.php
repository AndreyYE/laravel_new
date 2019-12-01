@extends('layouts.app')

@section('content')
    <div class="d-flex flex-row mb-3 justify-content-around">
        <a href="{{ route('admin.advert.categories.create',['parent'=>$category->id]) }}" class="btn btn-success mr-1">Add Category</a>

        <a href="{{ route('admin.advert.categories.attributes.create',['category'=>$category]) }}" class="btn btn-success mr-1">Add Attribute</a>

        <a href="{{ route('admin.advert.categories.edit', $category) }}" class="btn btn-primary mr-1">Edit</a>

        <form method="POST" action="{{ route('admin.advert.categories.destroy', $category) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $category->id }}</td>
        </tr>
        <tr>
            <th>Region</th><td>{{ $category->name }}</td>
        </tr>
        <tr>
            <th>Slug</th><td>{{ $category->slug }}</td>
        </tr>
        <tr>
            <th>Parent</th>
            <td>{{$category->parent ? $category->parent->name : 'It is a main region'}}</td>
        </tr>
        </tbody>
    </table>


    <table class="table">
        <thead>
        <tr>
            <th>Sort</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Required</th>
        </tr>
        </thead>
        <tbody>

        <tr><th colspan="4">Parent attributes</th></tr>

        @foreach ($parentAttributes as $attributess)
            @foreach($attributess as $attribu)
                <tr>
                    <td>{{ $attribu->sort }}</td>
                    <td>{{ $attribu->name }}</td>
                    <td>{{ $attribu->type }}</td>
                    <td>{{ $attribu->required ? 'Yes' : '' }}</td>
                </tr>
            @endforeach
        @endforeach

        <tr><th colspan="4">Own attributes</th></tr>
        @forelse ($attributes as $attribute)
            <tr>
                <td>{{ $attribute->sort }}</td>
                <td>
                    <a href="{{ route('admin.advert.categories.attributes.show', ['category'=>$category, 'attribute'=>$attribute]) }}">{{ $attribute->name }}</a>
                </td>
                <td>{{ $attribute->type }}</td>
                <td>{{ $attribute->required ? 'Yes' : '' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">None</td></tr>
        @endforelse

        </tbody>
    </table>

{{--@include('admin.adverts.categories._list')--}}
@endsection
