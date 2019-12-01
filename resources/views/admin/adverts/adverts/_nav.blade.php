{{--@include ('admin._nav', ['page' => 'adverts'])--}}
<ul class="nav nav-tabs mb-3">
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link" href="{{route('admin.home')}}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active " href="{{route('admin.advert.adverts.index')}}">Adverts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('admin.regions.index')}}">Regions</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('admin.advert.categories.index')}}">Categories</a></li>
        <li class="nav-item"><a class="nav-link " href="{{route('admin.users.index')}}">Users</a></li>
    </ul>
</ul>
