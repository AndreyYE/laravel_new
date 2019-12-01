@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'adverts_categories'])
    @include('admin.adverts.categories._list')
{{--    {{ $regions->links() }}--}}
@endsection
