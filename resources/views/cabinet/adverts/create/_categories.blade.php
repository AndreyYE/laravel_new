<ul>
    @foreach($categories as $category)
        <a href="{{route('cabinet.adverts.create.region', [$category])}}">{{$category->name}}</a>
        @include('cabinet.adverts.create._categories', ['categories'=> $category->children])
    @endforeach
</ul>