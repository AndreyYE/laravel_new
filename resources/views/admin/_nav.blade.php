
<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link{{ $page === '' ? ' active' : '' }}" href="{{ route('admin.home') }}">Dashboard</a></li>
    @can ('manage-adverts')
        <li class="nav-item"><a class="nav-link{{ $page === 'adverts' ? ' active' : '' }}" href="{{ route('admin.advert.adverts.index') }}">Adverts</a></li>
    @endcan
    @can ('manage-promo')
        <li class="nav-item"><a class="nav-link {{ $page === 'promo' ? ' active' : '' }}" href="{{ route('admin.promo.index') }}">Promo</a></li>
    @endcan
    @can ('manage-regions')
        <li class="nav-item"><a class="nav-link{{ $page === 'regions' ? ' active' : '' }}" href="{{ route('admin.regions.index') }}">Regions</a></li>
    @endcan
    @can ('manage-adverts-categories')
        <li class="nav-item"><a class="nav-link{{ $page === 'adverts_categories' ? ' active' : '' }}" href="{{ route('admin.advert.categories.index') }}">Categories</a></li>
    @endcan
    @can ('manage-pages')
        <li class="nav-item"><a class="nav-link{{ $page === 'pages' ? ' active' : '' }}" href="{{ route('admin.pages.index') }}">Pages</a></li>
    @endcan
    @can ('manage-users')
        <li class="nav-item"><a class="nav-link{{ $page === 'users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
    @endcan
{{--    @can ('manage-tickets')--}}
{{--        <li class="nav-item"><a class="nav-link{{ $page === 'tickets' ? ' active' : '' }}" href="{{ route('admin.tickets.index') }}">Tickets</a></li>--}}
{{--    @endcan--}}
</ul>
