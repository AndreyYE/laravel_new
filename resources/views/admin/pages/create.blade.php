@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'pages'])

    <form id="create_page" method="POST" action="{{ route('admin.pages.store', request()->input('parent') ? ['parent'=>request()->input('parent')] : ['parent'=>null]) }}">
        @csrf

        <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="menu_title" class="col-form-label">Menu Title</label>
            <input id="menu_title" class="form-control{{ $errors->has('menu_title') ? ' is-invalid' : '' }}" name="menu_title" value="{{ old('menu_title') }}">
            @if ($errors->has('menu_title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('menu_title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug" class="col-form-label">Slug</label>
            <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') }}" required>
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="content" class="col-form-label">Content</label>
            <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }} summernote" data-image-url="{{ route('admin.ajax.upload.image') }}" data-image-delete="{{ route('admin.ajax.delete.image') }}" name="content" rows="10" required>{{ old('content') }}</textarea>
            @if ($errors->has('content'))
                <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="3">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
@section('scripts')
<script type="text/javascript">
    window.onload = function () {
        let form =$("#create_page");
        let url = form.data('image-delete');
        form.submit(function(e){
            let allImages = sessionStorage.getItem('allImages');
            let img = $( "#edit_page" ).find( "img" );
            let currentImages = [];
            img.each(function(index){
                currentImages.push(this.src)
            });
            let allImage_array = allImages.split(',');
            let need_delete_images = [];
            for (let i = 0; i < allImage_array.length; i++) {
                if(!currentImages.includes(allImage_array[i])){
                    if(allImage_array[i]){
                        need_delete_images.push(allImage_array[i]);
                    }
                }
            }
            axios.post(url, {
                need_delete_images
            })
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    }
</script>
@endsection
