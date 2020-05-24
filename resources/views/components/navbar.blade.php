@can('is-user')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Početna</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ticket.create') }}">Otvori tiket</a>
    </li>
@endcan

@can('is-admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Početna</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.create') }}">Dodaj korisnika</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ticket.statistics') }}">Statistika tiketa</a>
    </li>
@endcan