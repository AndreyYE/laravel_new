<a href="{{route('admin.pages.create')}}" class="btn btn-success">Create Page</a>
@if(!$pages->isEmpty())
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Menu_title</th>
        <th>Slug</th>
        <th>Content</th>
        <th>Description</th>
        <th>Create Children Page</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach ($pages as $page)
        <tr>
            <td>{{ $page->id }}</td>
            <td>
                @if($page->depth>0)
                    @for($i = 0; $i < $page->depth; $i++)
                        -
                    @endfor
                @endif
                <a href="{{ route('admin.pages.show', $page) }}">{{ $page->title }}</a>
            </td>
            <td>{{ $page->menu_title }}</td>
            <td>{{ $page->slug }}</td>
            <td>{{ $page->content }}</td>
            <td>{{ $page->description }}</td>
            <td><a href="{{route('admin.pages.create',['parent'=>$page->id])}}" class="btn btn-success">Create</a></td>
            <td>
                <div class="d-flex flex-row">
                    <form method="post" action="{{route('admin.pages.first', $page)}}">
                        @csrf
                        <button class="btn btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.pages.up', $page)}}">
                        @csrf
                        <button class="btn btn-outline-primary ml-1"><span class="fa fa-angle-up"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.pages.down', $page)}}">
                        @csrf
                        <button class="btn btn-outline-primary ml-1"><span class="fa fa-angle-down"></span></button>
                    </form>
                    <form method="post" action="{{route('admin.pages.last', $page)}}">
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
