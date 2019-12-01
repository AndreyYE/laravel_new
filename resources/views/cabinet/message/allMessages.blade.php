@extends('layouts.app')

@section('content')
   <div class="row">
       <div class="col-sm-12">
           <table class="table">
               <thead class="thead-light">
               <tr>
                   <th scope="col">Author</th>
                   <th scope="col">Advert</th>
                   <th scope="col">Photo</th>
               </tr>
               </thead>
               <tbody>
               <tr>
                   <td>{{$dialog[0]->advert->user->name}}</td>
                   <td>
                       <a href="{{route('adverts.show',['advert'=>$dialog[0]->advert])}}">{{$dialog[0]->advert->title}}</a>
                   </td>
                   <td>
                       <img src="{{asset('build/'.$dialog[0]->advert->photos()->first()->file)}}" alt="No Photo" height="70px">
                   </td>
               </tr>
               </tbody>
           </table>
       </div>
       <div class="col-sm-12">
           <div class="overflow-auto" style="height: 25vh">
               @foreach($dialog[0]->messages as $message)
                   <div class="text-white {{$message->user->id == $dialog[0]->advert->user->id ? 'bg-dark' : 'bg-info'}}">{{$message->user->name}}</div>
                   <div class="{{$message->user->id == $dialog[0]->advert->user->id ? 'text-right' : 'text-left'}}">{!! $message->message !!}</div>
               @endforeach
           </div>
       </div>
       <div class="col-sm-12">
           <form id="create_message" method="POST" action="{{ route('cabinet.send.message',['dialog'=>$dialog[0]])}}">
               @csrf

               <div class="form-group">
                   <label for="message" class="col-form-label">Message</label>
                   <textarea id="message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }} summernote" data-image-url="{{ route('admin.ajax.upload.image') }}" data-image-delete="{{ route('admin.ajax.delete.image') }}" name="message" rows="10" required>{{ old('message') }}</textarea>
                   @if ($errors->has('message'))
                       <span class="invalid-feedback"><strong>{{ $errors->first('message') }}</strong></span>
                   @endif
               </div>

               <div class="form-group">
                   <button type="submit" class="btn btn-primary">Send</button>
               </div>
           </form>
       </div>
   </div>
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

