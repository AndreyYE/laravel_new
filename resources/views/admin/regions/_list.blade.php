@if(!$regions->isEmpty())
    <a href="{{ route('admin.regions.create') }}" class="btn btn-success">Create Region</a>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Region</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($regions as $region)
        <tr>
            <td>{{ $region->id }}</td>
            <td><a href="{{ route('admin.regions.show', $region) }}">{{ $region->name }}</a></td>
            <td>{{ $region->slug }}</td>
        </tr>
    @endforeach

    </tbody>
</table>
@endif
