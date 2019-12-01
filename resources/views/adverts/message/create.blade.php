@extends('layouts.app')

@section('content')
{{--    @include('admin.adverts.categories._nav')--}}
    <form id="create_message" method="POST" action="{{ route('adverts.send.message',['advert'=>$advert->id])}}">
        @csrf

        <div class="form-group">
            <label for="message" class="col-form-label">message</label>
            <textarea id="message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }} summernote" data-image-url="{{ route('admin.ajax.upload.image') }}" data-image-delete="{{ route('admin.ajax.delete.image') }}" name="message" rows="10" required>{{ old('message') }}</textarea>
            @if ($errors->has('message'))
                <span class="invalid-feedback"><strong>{{ $errors->first('message') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">
        window.onload = function () {
            let form =$("#create_message");
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
