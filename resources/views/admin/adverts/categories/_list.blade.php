@if(!$categories->isEmpty())
    <a class="btn btn-success mb-3" href="{{route('admin.advert.categories.create')}}">Create new category</a>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Slug</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>
                @if($category->depth>0)
                    @for($i = 0; $i < $category->depth; $i++)
                        -
                    @endfor
                @endif
                <a href="{{ route('admin.advert.categories.show', $category) }}">{{ $category->name }}</a>
            </td>
            <td>{{ $category->slug }}</td>
            <td>
                <div class="d-flex flex-row">
                    <form method="post" action="{{route('admin.advert.categories.first', $category)}}">
                        @csrf
                        <button class="btn btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.advert.categories.up', $category)}}">
                        @csrf
                        <button class="btn btn-outline-primary ml-1"><span class="fa fa-angle-up"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.advert.categories.down', $category)}}">
                        @csrf
                        <button class="btn btn-outline-primary ml-1"><span class="fa fa-angle-down"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.advert.categories.last', $category)}}">
                        @csrf
                        <button class="btn btn-outline-primary ml-1"><span class="fa fa-angle-double-down"></span></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
@endif
