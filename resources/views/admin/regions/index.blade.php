@extends('layouts.app')

@section('content')
    @include('admin._nav',['page'=>'regions'])
    @include('admin.regions._list')
    {{ $regions->links() }}
@endsection
