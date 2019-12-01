@extends('layouts.app')

@section('content')
    <form name="form_search" method="get" action="{{route('adverts.my_advert',['category'=>$category,'region'=>$region ? $region : 'allRegions'])}}">
        <div class="row">
            <div class="col-md-4 position-relative">
                <input id="search" name="search" type="text" class="form-control" placeholder="Search" {{$search ? 'value='.$search:''}}>
            </div>
            <div class="col-md-4 border border-dark">
                <select name="region" class="custom-select mr-sm-2 change_input" id="search_region">
                    <option {{empty($region) ? 'selected':''}} value="allRegions">all regions</option>
                    @foreach($allRegions as $key=>$regions)
                        @foreach($regions as $reg)
                            @if($reg->parent_id === null)
                                <option value="{{$reg->id}}" {{empty(!$region)?($region['id']==$reg['id'] ? 'selected':''):''}}>{{$reg->name}}</option>
                                @if(isset($allRegions[$reg->id]))
                                @include('adverts._regions',['allRegions'=>$allRegions,'region'=>$region,'regions'=>$allRegions[$reg->id],'add'=>'-'])
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 border border-dark">
                <select name="category" class="custom-select mr-sm-2 change_input" id="category" data-routeChangeCategory="{{route('adverts.changeCategory')}}">
                    @foreach($allCategories as $cat)
                        @if($cat->depth>0)
                            <option value="{{$cat->id}}" {{$cat->id == $category? 'selected' : ''}}>
                                @for ($i = 0; $i < $cat->depth; $i++)
                                    -
                                @endfor
                                <div>
                                    {{$cat->name}}
                                </div>
                            </option>
                            @else
                            <option value="{{$cat->id}}" {{$cat->id==$category ? 'selected' : ''}}>
                                <div>
                                    {{$cat->name}}
                                </div>
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            @foreach($attributes as $attribute)
                @if($attribute['variants'] and $attribute['type']==='slider')
                    <div class="col-md-4 border border-dark">
                        <label class="mr-sm-2" for="{{$attribute['id']}}">{{$attribute['name']}}</label>
                        <input name="{{$attribute['id']}}" id="{{$attribute['id']}}" type="text" class="js-range-slider change_input" value=""
                               data-type="double"
                               data-min="{{$attribute['variants'][0]}}"
                               data-max="{{$attribute['variants'][1]}}"
                               data-from={{array_key_exists($attribute['id'], $selected_attributes) ? explode(";",$selected_attributes[$attribute['id']])[0] : ''}}
                               data-to={{array_key_exists($attribute['id'], $selected_attributes)  ? explode(";",$selected_attributes[$attribute['id']])[1] : ''}}
                               data-grid="true"
                        />
                    </div>
                @endif
                @if($attribute['variants'] and $attribute['type']!=='slider')
                    <div class="col-md-4 border border-dark">
                        <label class="mr-sm-2" for="{{$attribute['id']}}">{{$attribute['name']}}</label>
                        <select name="{{$attribute['id']}}" class="custom-select mr-sm-2 change_input" id="{{$attribute['id']}}">
                            <option {{isset($selected_attributes[$attribute['id']])?'':'selected'}}></option>
                            @foreach($attribute['variants'] as $variant)
                                <option {{isset($selected_attributes[$attribute['id']])? ($selected_attributes[$attribute['id']]==trim($variant)?'selected':''):''}}>{{$variant}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                        @if($attribute['type'] === 'integer')
                                <div class="col-md-4 border border-dark">
                                   <label for="{{$attribute['id']}}">{{$attribute['name']}}</label>
                                    <input name="{{$attribute['id']}}" type="number" class="form-control change_input" id="{{$attribute['id']}}" placeholder="{{$attribute['name']}}">
                                </div>
                        @endif
                @endif
            @endforeach
            <div class="col-md-4 border border-dark">
                <label class="mr-sm-2" for="price">Price</label>
                <input name="price" id="price" type="text" class="js-range-slider change_input" value=""
                       data-type="double"
                       data-min="0"
                       data-max="{{$max_price}}"
                       data-from="{{$price[0] ? $price[0] : 0}}"
                       data-to="{{count($price)>1 ? $price[1] : $max_price}}"
                       data-grid="true"
                />
            </div>
            <div class="col-md-4 align-self-center text-center border border-dark">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary {{$sort==1 || !$sort ? 'active' : ''}} sort_settings">
                        <input type="radio" name="sort" id="option1" autocomplete="off" value="1">New
                    </label>
                    <label class="btn btn-secondary {{$sort==2 ? 'active' : ''}} sort_settings">
                        <input type="radio" name="sort" id="option2" autocomplete="off" value="2">Cheap
                    </label>
                    <label class="btn btn-secondary {{$sort==3 ? 'active' : ''}} sort_settings">
                        <input type="radio" name="sort" id="option3" autocomplete="off" value="3">Expensive
                    </label>
                </div>
            </div>
            <div class="col-md-4 border border-dark text-center">
                <button type="submit" id="delete_filter" class="btn btn-danger">Delete Filter</button>
            </div>
            <div class="col-md-4 border border-dark text-center">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </div>
    </form>
    @if($categories->count())
        <div class="display-4">Next Category</div>
        <div class="row">
            @foreach($categories as $cat)
                <div class="col-md-4">
                    <a href="{{route('adverts.my_advert',['category'=> $cat ? $cat->id:'allCategories', 'region'=> empty($region) ? 'allRegions' : $region])}}">{{$cat->name}}</a>
                </div>
            @endforeach
        </div>
    @endif
    <div class="my-5 display-4 text-center">Adverts</div>
    <div class="row" id="adverts">
        @foreach($adverts['hits']['hits'] as $advert)
        <div class="col-md-12 border border-primary ">
            <div class="row text-center align-items-center">
                <div class="col-md-3"><img src="{{count($advert['_source']['photo']) ?
                asset('build/'.$advert['_source']['photo'][0]) :
                ''}}" alt="Not Found Photo" class="img-thumbnail img-fluid"></div>
                <div class="col-md-7"><a class="view advert_font_size" data-view="{{route('adverts.view',['advert'=>$advert['_id']])}}" href="{{route('adverts.show',['advert'=>$advert['_id']])}}">{{\Illuminate\Support\Str::limit($advert['_source']['title'], 20)}}</a></div>
                <div class="col-md-2 advert_font_size">{{$advert['_source']['price']}}</div>
            </div>
        </div>
        @endforeach
    </div>
    @if($adverts['hits']['total'])
    <div class="row">
        <div class="col-sm-12">
            <ul class="pagination">
                                <li class="page-item {{$pagination == 1 ? 'disabled' : ''}}">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                @for($i = 0; $i < ceil($adverts['hits']['total']/20); $i++)
                                    <li class="page-item {{$pagination == $i+1 ? 'active': ''}}">
                                        <a class="page-link" href="#">{{$i+1}}</a>
                                    </li>
                @endfor
                                <li class="page-item {{$pagination == ceil($adverts['hits']['total']/20) ? 'disabled' : ''}}">
                                    <a class="page-link" href="#">Next</a>
                                </li>
            </ul>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
    <script type="text/javascript">
        window.addEventListener("load", function(event) {

            $(".js-range-slider").ionRangeSlider();
            $('form[name="form_search"]').change(function(e){
                if(e.target.name === "category" || e.target.name === "region"){
                    let category = $('select[name="category"]').val();
                    let region = $('select[name="region"]').val();
                    window.location.href = window.location.protocol + "//" + window.location.host + "/adverts/" + category + "/" + region
                }
            });

         // delete filter
            $("#delete_filter").click((e)=>{
                e.preventDefault();
                let region = $("#search_region").val();
                if(region === 'all regions'){
                    region = 'allRegions';
                }
                let category = $("#category").val();
                baseUrl = window.location.protocol + "//" + window.location.host + "/adverts/"+category+"/"+region;
                window.location.replace(baseUrl);
            });

           // pagination
            $(".pagination").click((e)=>{
                e.preventDefault();
                let ul = $(e.currentTarget);
                let children = ul.children();

                let url_string = window.location.href; //window.location.href
                let url = new URL(url_string);
                let query_string = url.search;
                let c = new URLSearchParams(query_string);
                if($.trim($(e.target).text()) == 'Previous'){
                    if(children[1].classList.contains('active')){
                        return false;
                    }else{
                        let pagination ='';
                        for (let i = 0; i < children.length; i++) {
                            if(children[i].classList.contains('active')){
                                pagination = i-1;
                                break;
                            }
                        }
                        c.set('pagination', pagination);
                        url.search = c.toString();
                        let new_url = url.toString();
                        window.location.href = new_url;
                    }

                }
                if($.trim($(e.target).text()) == 'Next'){
                    if(children[children.length-2].classList.contains('active')){
                        return false;
                    }else{
                        let pagination ='';
                        for (let i = 0; i < children.length; i++) {
                            if(children[i].classList.contains('active')){
                                pagination = i+1;
                                break;
                            }
                        }
                        c.set('pagination', pagination);
                        url.search = c.toString();
                        let new_url = url.toString();
                        window.location.href = new_url;
                    }
                }
                if($.isNumeric($.trim($(e.target).text()))){
                    c.set('pagination', $.trim($(e.target).text()));
                    url.search = c.toString();
                    let new_url = url.toString();
                    window.location.href = new_url;
                }
            });
        // Add view advert
            $(".view").click(function(e){
                let route = $(e.target).data('view');
                axios.post(route)
                .then(response=>{
                    console.log(response);
                })
                .catch(error=>{
                    console.log(error)
                })
            });
        });
    </script>
@endsection
