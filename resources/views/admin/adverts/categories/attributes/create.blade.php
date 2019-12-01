@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'adverts_categories'])
    <form method="POST" action="{{ route('admin.advert.categories.attributes.store',[$category])}}">
        @csrf

        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label">Type</label>
           <select name="type" id="type">
               <option></option>
               @foreach(\App\Entity\Adverts\Attribute::typeList() as $type)
               <option value="{{ $type }}"{{ $type == old('type') ? ' selected' : '' }}>{{$type}}</option>
               @endforeach
           </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
            @endif
        </div>

        <div class="form-group row">
            <div class="col-sm-2">Required</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="required" name="required">
                    <label class="form-check-label" for="required">
                        Required
                    </label>
                    @if ($errors->has('required'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('required') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="variants" class="col-sm-2 col-form-label">Variants</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="variants" id="variants" placeholder="write your options separated by commas">
            </div>
        </div>

        <div class="form-group">
            <label for="sort" class="col-form-label">Sort</label>
            <input id="sort" class="form-control{{ $errors->has('sort') ? ' is-invalid' : '' }}" name="sort" value="{{ old('sort') }}" required>
            @if ($errors->has('sort'))
                <span class="invalid-feedback"><strong>{{ $errors->first('sort') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
