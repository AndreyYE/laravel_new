@extends('layouts.app')

@section('content')
    @if($adverts)
    @include('cabinet._nav',['page'=>'promo'])
    <table class="table text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Click</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adverts as $val)
        <tr>
                <td><a href="{{route('adverts.show', $val)}}">{{$val->title}}</a></td>
                <td>{{$val->click}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $adverts->links() }}
        @else
        <h1>Вы не продвигаете ни одного объявнения</h1>
    @endif
@endsection
