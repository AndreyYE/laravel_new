@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'adverts_categories'])

    <form method="POST" action="{{ route('admin.advert.categories.update', ['category'=>$category]) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $category->name) }}" required>
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug" class="col-form-label">Slug</label>
            <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug', $category->slug) }}" required>
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="parent" class="col-form-label">Parent</label>
            <select name="parent" id="parent" class="form-control form-control-lg">
                <option></option>
                @foreach($categories as $cat)
                    <option>
                        @if($cat->depth)
                            @for ($i = 0; $i < $cat->depth; $i++)
                                -
                            @endfor
                        @endif
                        {{$cat->name}}
                    </option>
                @endforeach
            </select>
{{--            <input id="slug" type="text" class="form-control{{ $errors->has('parent') ? ' is-invalid' : '' }}" name="slug" value="{{ old('parent', $category->parent_id) }}" required>--}}
            @if ($errors->has('parent'))
                <span class="invalid-feedback"><strong>{{ $errors->first('parent') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
