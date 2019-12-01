@extends('layouts.app')

{{--@section('search')--}}
{{--    @include('layouts.partials.search', ['category' => $category, 'route' => '?'])--}}
{{--@endsection--}}
@section('breadcrumbs')

@endsection
@section('content')
    <form name="form_search" method="get" data-routesearch="{{route('adverts.my_advert',['category'=>1,'region'=>1])}}">
        <div class="row">
            <div class="col-md-4">
                <input id="search" name="search" type="text" class="form-control" placeholder="Search">
            </div>
            <div class="col-md-3">
                <select name="region" class="custom-select mr-sm-2 change_input" id="search_region">
                    <option value="allRegions"></option>
                    @foreach($allRegions as $key=>$regions)
                        @foreach($regions as $reg)
                            @if($reg->parent_id === null)
                                <option value="{{$reg->id}}" class="bg-info">{{$reg->name}}</option>
                                @if(isset($allRegions[$reg->id]))
                                    @include('adverts._regions',['allRegions'=>$allRegions,'region'=>'','regions'=>$allRegions[$reg->id],'add'=>'-'])
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="custom-select mr-sm-2 change_input" id="category">
                    @foreach($allCategories as $cat)
                        @if($cat->depth>0)
                            <option value="{{$cat->id}}">
                                @for ($i = 0; $i < $cat->depth; $i++)
                                    -
                                @endfor
                                <div>{{$cat->name}}
{{--                                    @if(count($adverts['aggregations']['group_by_category']['buckets']))--}}
{{--                                        @foreach($adverts['aggregations']['group_by_category']['buckets'] as $k_bucket=>$val_bucket)--}}
{{--                                            @if($val_bucket['key']==$cat->id)--}}
{{--                                                <span>--}}
{{--                                            {{$val_bucket['doc_count']}}--}}
{{--                                        </span>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </div>
                            </option>
                        @else
                            <option value="{{$cat->id}}">
                                <div>{{$cat->name}}
{{--                                    @if(count($adverts['aggregations']['group_by_category']['buckets']))--}}
{{--                                        @foreach($adverts['aggregations']['group_by_category']['buckets'] as $k_bucket=>$val_bucket)--}}
{{--                                            @if($val_bucket['key']==$cat->id)--}}
{{--                                                <span>--}}
{{--                                            {{$val_bucket['doc_count']}}--}}
{{--                                        </span>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </div>
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </div>
    </form>

    @if ($categories)
        <div class="card card-default mb-3 mt-5">
            <div class="card-header text-center display-4">
              All Categories
            </div>
            <div class="card-body pb-0" style="color: #aaa">
                <div class="row">
                    @foreach (array_chunk($categories, 3) as $chunk)
                        <div class="col-md-3">
                            <ul class="list-unstyled list-group">
                                @foreach ($chunk as $current)
                                    <li class="list-group-item list-group-item-primary text-center">
                                        <a href="{{route('adverts.my_advert',['category'=> $current ? $current:'allCategories', 'region'=> isset($region) ? $region :'allRegions'])}}" class="btn btn-outline-danger">{{$current->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
<div class="row text-center">
    <div class="col-sm-12 text-capitalize display-4">
        Самые поулярные объвления
    </div>
@if($most_popular_adverts)
    @foreach($most_popular_adverts['hits']['hits'] as $advert)
        <div class="col-sm-3 mb-3">
            <div class="card bg-secondary mx-auto text-white" style="width: 10rem;">
                <img src="{{ asset('build/'.$advert['_source']['photo'][0]) }}" class="card-img-top" alt="НЕТ ФОТО">
                <div class="card-body">
                    <h5 class="card-title">{{\Illuminate\Support\Str::limit($advert['_source']['title'], 20)}}</h5>
                    <p class="card-text">{{\Illuminate\Support\Str::limit($advert['_source']['content'],20)}}</p>
                    <a href="{{route('adverts.show',['advert'=>$advert['_source']['id']])}}" class="btn btn-primary">Показать</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
@section('scripts')
   <script type="text/javascript">
       window.addEventListener('load',function(){
          $("form[name='form_search']").submit(function(e){
              e.preventDefault();
              let route_full = $(this).data('routesearch');
              let route_length = route_full.length-3;
              let url = route_full.slice(0, route_length);
              let formData = new FormData(this);
              let region = formData.get('region');
              let category = formData.get('category');
              let search = formData.get('search');
              let href = url+category;
              if(region){
                  href = href+'/'+region;
              }
              if(search){
                  href = href+'?search='+search;
              }
              window.location.href = href;
          })
       });
   </script>
@endsection
