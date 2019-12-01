@extends('layouts.app')

@section('content')
    @include('cabinet._nav',['page' => 'messages'])
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">
                <form>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check all dialog</label>
                    </div>
                </form>
            </th>
            <th scope="col">Delete</th>
            <th scope="col">User</th>
            <th scope="col">Advert</th>
            <th scope="col">Message</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allDialogs as $dialog)
        <tr class="check_all_message">
            <th scope="row">
                <form>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    </div>
                </form>
            </th>
            <th>
                @if($dialog->client->id === request()->user()->id)
                <a class="btn btn-danger" href="{{route('cabinet.messages.delete',['id'=>$dialog->id])}}" aria-label="Delete">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
                @endif
            </th>
            <td>{{$dialog->client->name}}</td>
            <td>{{$dialog->advert->title}}</td>
            <td>
                <a href="{{route('cabinet.messages.all',['dialog'=>$dialog->id])}}">You have {{Auth::id() == $dialog->user_id ? $dialog->user_new_messages: $dialog->client_new_messages}} missed {{count($dialog->messages)>1 ? 'messages' : 'message'}}</a>
            </td>
            <td>{{$dialog->updated_at}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection

