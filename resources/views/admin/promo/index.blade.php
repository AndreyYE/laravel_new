@extends('layouts.app')

@section('content')
    @if($adverts)
    @include('admin._nav',['page'=>'promo'])
    <form method="GET" action="?">
        <div class="row text-center align-items-center">
            <div class="col-md-2">
                <div class="form-group">
                    <label>ID</label>
                    <input name="id" type="number" min="0" value="{{request('id')? request('id'):''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="d-block">Title</label>
                    <input name="title" type="text" value="{{request('title') ? request('title'):''}}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="d-block">Clicks</label>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary {{$request->input('options1')==='on'? "active":''}}">
                        <input type="radio" name="options1" id="options1" autocomplete="off"> Min
                    </label>

                    <label class="btn btn-secondary {{$request->input('options2')==='on'? "active":''}}">
                        <input type="radio" name="options2" id="options2" autocomplete="off"> Max
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <a class="btn btn-danger" href="{{route('admin.promo.index')}}">Delete Filter</a>
                </div>
            </div>
        </div>
    </form>

    <table class="table text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Click</th>
            <th scope="col">Close</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adverts as $var)
        <tr>
            <td>{{$var->id}}</td>
            <td><a href="{{route('adverts.show', $var)}}">{{$var->title}}</a></td>
            <td>{{$var->click}}</td>
            <td><a class="btn btn-danger" href="{{route('admin.promo.close',['advert'=>$var->id])}}">Close</a></td>
            <td><a class="btn btn-success" href="{{route('admin.promo.edit',['advert'=>$var->id])}}">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $adverts->appends($request->all())->links()}}
        @else
        <h1>Вы не продвигаете ни одного объявнения</h1>
    @endif
@endsection
