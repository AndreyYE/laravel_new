<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link {{ $page === '' ? ' active' : '' }}" href="{{ route('cabinet.home') }}">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'profile' ? ' active' : '' }}" href="{{ route('cabinet.profile.index') }}">Profile</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'adverts' ? ' active' : '' }}" href="{{ route('cabinet.adverts.index') }}">Adverts</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'favorites' ? ' active' : '' }}" href="{{ route('cabinet.favorites.index') }}">Favorites</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'messages' ? ' active' : '' }}" href="{{ route('cabinet.messages.index') }}">Messages</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'promo' ? ' active' : '' }}" href="{{ route('cabinet.promo.index') }}">Promo</a></li>
    <li class="nav-item"><a class="nav-link {{ $page === 'api' ? ' active' : '' }}" href="{{ url('/docs/index.html') }}" target="_blank">Api</a></li>
</ul>
