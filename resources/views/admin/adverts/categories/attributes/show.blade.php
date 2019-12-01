@extends('layouts.app')

@section('content')
    <div class="d-flex flex-row mb-3 justify-content-around">

        <a href="{{ route('admin.advert.categories.attributes.edit', [$category, $attribute]) }}" class="btn btn-primary mr-1">Edit</a>

        <form method="POST" action="{{ route('admin.advert.categories.attributes.destroy', [$category, $attribute]) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $attribute->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $attribute->name }}</td>
        </tr>
        <tr>
            <th>Type</th><td>{{ $attribute->type }}</td>
        </tr>
        <tr>
            <th>Required</th><td>{{$attribute->required}}</td>
        </tr>
        <tr>
            <th>Variants</th><td>
                @if($attribute->isSelect() || $attribute->isSlider())
                @foreach($attribute->variants as $variant)
                        {{$variant}},
                @endforeach
                    @else
                    No variants
                @endif
               </td>
        </tr>
        </tbody>
    </table>
{{--@include('admin.adverts.categories._list')--}}
@endsection
