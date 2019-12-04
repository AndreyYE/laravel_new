@extends('layouts.app')

@section('content')
    @if ($advert->isDraft())
        <div class="alert alert-danger">
            It is a draft.
        </div>
        @if ($advert->reject_reason)
            <div class="alert alert-danger">
                {{ $advert->reject_reason }}
            </div>
        @endif
    @endif
    @if($advert->isModeration())
        <div class="alert alert-danger">
            It is a moderation.
        </div>
    @endif

     @can ('manage-adverts')
        <div class="alert-warning">Admin-Button</div>
        <div class="d-flex flex-row mb-3">

            <a href="{{ route('admin.advert.adverts.edit', $advert) }}" class="btn btn-primary mr-1">Edit</a>

            <a href="{{ route('admin.advert.adverts.photos', $advert) }}" class="btn btn-primary mr-1">Photos</a>

            @if ($advert->isOnModeration())
                <form method="POST" action="{{ route('admin.advert.adverts.moderate', $advert) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Moderate</button>
                </form>
            @endif

            @if ($advert->isOnModeration() || $advert->isActive())

                <a href="{{ route('admin.advert.adverts.reject', $advert) }}" class="btn btn-danger mr-1">Reject</a>
            @endif

            <form method="POST" action="{{ route('admin.advert.adverts.destroy', $advert) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('admin.advert.adverts.attributes', $advert) }}" class="btn btn-primary mr-1">Edit Attributes</a>
        </div>
    @endcan

    @can ('manage-own-advert', $advert)
        <div class="alert-warning">User-Button</div>
        <div class="d-flex flex-row mb-3">
{{--            done--}}
            <a href="{{ route('cabinet.adverts.edit', $advert) }}" class="btn btn-primary mr-1">Edit</a>
            {{--            done--}}
            <a href="{{ route('cabinet.adverts.photos', $advert) }}" class="btn btn-primary mr-1">Photos</a>

            @if ($advert->isDraft())
                <form method="POST" action="{{ route('cabinet.adverts.send', $advert) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Publish</button>
                </form>
            @endif
            @if ($advert->isActive())
                <form method="POST" action="{{ route('cabinet.adverts.close', $advert) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Close</button>
                </form>
            @endif
            {{--            done--}}
            <form method="POST" action="{{ route('cabinet.adverts.destroy', $advert) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    @endcan

    <div class="row">
        <div class="col-md-9">

            <p class="float-right" style="font-size: 36px;">{{ $advert->price }}</p>
            <h1 style="margin-bottom: 10px">{{ $advert->title  }}</h1>
            <p>
                @if ($advert->expires_at)
                    Дата публикиции: {{ $advert->published_at }} &nbsp;
                @endif
                @if ($advert->expires_at)
                    Дата закрытия: {{ $advert->expires_at }}
                @endif
            </p>
            @if(count($advert->photos))
            <div style="margin-bottom: 20px" class="border border-dark">
                <div class="row">
                    <div class="col-10">
                        <img style="height: 400px; background: red; border: 1px solid #ddd" src="{{ asset('/build/'.$advert->photos[0]->file ) }}" class="img-fluid main-photo" alt="Responsive image">
                    </div>
                    <div class="col-2">
                        @foreach($advert->photos as $val)
                                <img style="height: 100px; background: red; border: 2px solid {{$advert->photos[0]->file !== $val->file?'':'red'}}" src="{{ asset('/build/'.$val->file ) }}" class="img-fluid secondary-photos" alt="Responsive image">
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <div class="bg-info text-white advert_font_size text-center">Описание</div>
            <p class="border border-dark">{!! nl2br(e($advert->content)) !!}</p>
            @canany(['manage-own-advert','manage-adverts'],$advert)
            <div class="row">
                <div class="col"><a class="btn btn-success mb-1" href="{{route('cabinet.adverts.attributes',['advert'=>$advert])}}">Edit Attributes</a></div>
            </div>
            @endcan
            <div class="bg-info text-white advert_font_size text-center">Характеристики</div>
            <table class="table table-bordered">
                <tbody>
                @foreach ($advert->category->allAttributes() as $allAttribute)
                    @foreach ($allAttribute as $attribute)
                    <tr>
                        <th>{{ $attribute['name'] }}</th>
                        <td>{{ $advert->getValue($attribute['id'])['value'] }}</td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>

            <p>Адрес: {{ $advert->address }}</p>

            <p style="margin-bottom: 20px">Продавец: {{ $advert->user->name }}</p>
            @cannot('edit-own-advert', $advert)
            <div class="d-flex flex-row mb-3">
                <a class="btn btn-success mr-1" href="{{route('adverts.form.send.message',["advert"=>$advert->id])}}"><span class="fa fa-envelope"></span> <span>Send Message</span></a>
                <span class="btn btn-primary phone-button mr-1" data-source="{{ route('adverts.phone', $advert) }}" data-setFlash="{{ route('adverts.setFlashMessage') }}"><span class="fa fa-phone"></span> <span class="number">Show Phone Number</span></span>
                @if ($user && $user->hasInFavorites($advert->id))
                    <form method="POST" action="{{ route('adverts.favorites', $advert) }}" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary"><span class="fa fa-star"></span> Remove from Favorites</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('adverts.favorites', $advert) }}" class="mr-1">
                        @csrf
                        <button class="btn btn-danger"><span class="fa fa-star"></span> Add to Favorites</button>
                    </form>
                @endif
            </div>
            @endcannot

            <hr/>
            @if($similar_adverts)
            <div class="bg-info text-white advert_font_size text-center">Похожие обьявления</div>
            <div class="row">
                @foreach($similar_adverts as $val)
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('/build/'.$val['_source']['photo'][0] ) }}" alt=""/>
                        <div class="card-body">
                            <div class="card-title h4 mt-0" style="margin: 10px 0"><a href="{{route('adverts.show',['advert'=>$val['_source']['id']])}}">{{\Illuminate\Support\Str::limit($val['_source']['title'],20)}}</a></div>
                            <p class="card-text" style="color: #666">{{\Illuminate\Support\Str::limit($val['_source']['content'],20)}}</p>
                            <p class="card-text" style="color: #666">Цена - {{$val['_source']['price']}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-md-3">
            @if(count($advert_adverts))
                @foreach($advert_adverts as $value)
                    <div class="card">
                        <img style="height: 400px; background: red; border: 1px solid #ddd" src="{{ asset('/build/'.$value['_source']['photo'][0] ) }}" class="img-fluid clickadvert" data-routeClickAdvert="{{route('adverts.clickAdvert',['advert'=>$value['_source']['id']])}}" data-showAdvert="{{route('adverts.show',['advert'=>$value['_source']['id']])}}" alt="Responsive image">
                    </div>
                    <div class="card-body">
                        <div class="card-title h4 mt-0" style="margin: 10px 0">{{$value['_source']['title']}}</div>
                        <div class="card-text h4 mt-0" style="margin: 10px 0">Цена - {{$value['_source']['price']}}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('scripts')
{{--    <script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>--}}

{{--    <script type='text/javascript'>--}}
{{--        ymaps.ready(init);--}}
{{--        function init(){--}}
{{--            var geocoder = new ymaps.geocode(--}}
{{--                '{{ $advert->address }}',--}}
{{--                { results: 1 }--}}
{{--            );--}}
{{--            geocoder.then(--}}
{{--                function (res) {--}}
{{--                    var coord = res.geoObjects.get(0).geometry.getCoordinates();--}}
{{--                    var map = new ymaps.Map('map', {--}}
{{--                        center: coord,--}}
{{--                        zoom: 7,--}}
{{--                        behaviors: ['default', 'scrollZoom'],--}}
{{--                        controls: ['mapTools']--}}
{{--                    });--}}
{{--                    map.geoObjects.add(res.geoObjects.get(0));--}}
{{--                    map.zoomRange.get(coord).then(function(range){--}}
{{--                        map.setCenter(coord, range[1] - 1)--}}
{{--                    });--}}
{{--                    map.controls.add('mapTools')--}}
{{--                        .add('zoomControl')--}}
{{--                        .add('typeSelector');--}}
{{--                }--}}
{{--            );--}}
{{--        }--}}
{{--    </script>--}}
    <script type="text/javascript">
        /* Show phone */
        function axiosShowPhone(url, target)
        {
            axios.get(url).then((data)=>{
                //console.log(data);
                let phone = document.querySelector('.phone_show');
                if(phone){
                    phone.remove();
                }
                let button = target.querySelector('.number');
                button.innerHTML = data.data;
                target.classList.add('disabled');

            }).catch((data)=>{
                if(data.response.status == 401){
                    axios.post($(target).data('setflash'))
                    .then(response=>{
                        if(response.data ==='ok'){
                            window.location.href = window.location.origin+'/login';
                        }
                    })
                    .catch(error=>{
                        console.log(error);
                    });
                }
            });
        }

        function showPhone(evt)
        {
            if(evt.target.classList.contains('phone-button')){
                axiosShowPhone(evt.target.dataset.source, evt.target);
            }else{
                axiosShowPhone(evt.target.closest('.phone-button').dataset.source, evt.target.closest('.phone-button'));
            }
        }

        function clickAdvert(evt)
        {
         let clickTarget = $(evt.target);
         let route = clickTarget.data('routeclickadvert');
         if(!sessionStorage.getItem(route)){
             sessionStorage.setItem(route, route);
             axios.post(route)
                 .then(res=>{
                     console.log('response '+res.data);
                 })
                 .catch(error=>{
                     console.log(error);
                 })
         }
          window.location.href = clickTarget.data('showadvert')
        }

        function change_secondary_photo(evt)
        {
            $('.secondary-photos').css({"border": "2px solid"});
            $(this).css({"border": "2px solid red"});
            $('.main-photo').attr('src',$(this).attr('src'))
        }
        function ready()
        {
            let button = document.querySelector('.phone-button');
            button.addEventListener('click',showPhone, false);

            let click_advert = document.querySelector('.clickadvert');
            if(click_advert){
                click_advert.addEventListener('click',clickAdvert);
            }

            $('.secondary-photos').click(change_secondary_photo)
        }
        document.addEventListener("DOMContentLoaded", ready, false);
    </script>
@endsection
