@extends('layouts.app')

@section('content')
    @include('cabinet._nav',['page' => 'adverts'])
<div class="row">
    <div class="col"><a class="btn btn-success mb-1" href="{{route('cabinet.adverts.create')}}">Create Advert</a></div>
</div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Updated</th>
            <th>Title</th>
            <th>Region</th>
            <th>Category</th>
            <th>Status</th>
            <th>Promotion</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($adverts as $advert)
            <tr>
                <td>{{ $advert->id }}</td>
                <td>{{ $advert->updated_at }}</td>
                <td><a href="{{ route('adverts.show', $advert) }}" target="_blank">{{ $advert->title }}</a></td>
                <td>
                    @if ($advert->region)
                        {{ $advert->region->name }}
                    @endif
                </td>
                <td>{{ $advert->category->name }}</td>
                <td>
                    @if ($advert->isDraft())
                        <span class="badge badge-secondary">Draft</span>
                    @elseif ($advert->isOnModeration())
                        <span class="badge badge-primary">Moderation</span>
                    @elseif ($advert->isActive())
                        <span class="badge badge-primary">Active</span>
                    @elseif ($advert->isClosed())
                        <span class="badge badge-secondary">Closed</span>
                    @endif
                </td>
                <td>
                    @can('permission_promote_advert',$advert)
                    <a href="{{route('cabinet.promo.create',['advert'=>$advert])}}" class="btn btn-success">Promotion</a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $adverts->links() }}
@endsection
