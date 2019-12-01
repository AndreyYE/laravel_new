@foreach($regions as $val)
    <option value="{{$val->id}}" {{empty(!$region)?($region['id']==$val['id'] ? 'selected':''):''}}>
        {{$add.''.$val->name}}
        @if(isset($allRegions[$val->id]))
            @include('adverts._regions',['allRegions'=>$allRegions,'region'=>$region,'regions'=>$allRegions[$val->id],'add'=>$add.'-'])
        @endif
    </option>
@endforeach

