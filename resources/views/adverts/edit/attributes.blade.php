@extends('layouts.app')

@section('content')
    <form method="POST" action="?">
        @csrf

        @foreach ($advert->category->allAttributes() as $attributes)
            @foreach($attributes as $attribute)
                <div class="form-group">
                    <label for=attribute_{{ $attribute['id'] }}" class="col-form-label">{{ $attribute['name'] }}</label>

                    @if($errors->has('attributes.' . $attribute['id']))
                        @foreach($errors->get('attributes.' . $attribute['id']) as $val)
                            <div class="alert alert-danger">
                                {{$val}}
                            </div>
                        @endforeach
                    @endif

                    @if (\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isSelect())
                        <select id="attribute_{{ $attribute['id'] }}" class="form-control{{ $errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : '' }}" name="attributes[{{ $attribute['id'] }}]">
                            <option value=""></option>
                            @foreach (\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants as $variant)
                                <option value="{{ $variant }}" {{\App\Entity\Adverts\Advert\Value::where('attribute_id',$attribute['id'])->where('advert_id',$advert->id)->first()['value'] == $variant ? 'selected':''}} {{$variant==old('attributes.'.$attribute['id']) ? 'selected':''}}>
                                    {{ $variant }}
                                </option>
                            @endforeach
                        </select>

                    @elseif (\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isNumber())

                        <input id="attribute_{{ $attribute['id'] }}" type="number" class="form-control {{ $errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : '' }}" name="attributes[{{ $attribute['id'] }}]" value="{{ old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value']) }}">

                    @elseif (\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isSlider())

                        <input id="attribute_{{ $attribute['id'] }}" type="text" class="js-range-slider {{ $errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : '' }}" name="attributes[{{ $attribute['id'] }}]" value=""
                               data-min="{{\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants[0]}}"
                               data-max="{{\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants[1]}}"
                               data-from="{{old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value'])}}"
                               data-grid="true"
                        />

                    @else
                        <input id="attribute_{{ $attribute['id'] }}" type="text" class="form-control{{ $errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : '' }}" name="attributes[{{ $attribute['id'] }}]" value="{{ old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value']) }}">

                    @endif

                    @if ($errors->has('parent'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('attributes.' . $attribute['id']) }}</strong></span>
                    @endif
                </div>
            @endforeach
        @endforeach

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        window.addEventListener('load',function(){
            $(".js-range-slider").ionRangeSlider();
        })
    </script>
@endsection
