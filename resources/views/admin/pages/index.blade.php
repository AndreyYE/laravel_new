@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'pages'])
    @include('admin.pages._list')
@endsection
