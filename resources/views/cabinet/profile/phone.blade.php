@extends('layouts.app')

@section('content')
   <div class="d-flex flex-row justify-content-between align-content">
   <form method="POST" action="{{ route('cabinet.profile.phone.verify') }}">
      @csrf
{{--      @method('PUT')--}}

      <div class="form-group">
         <label for="token" class="col-form-label">Token</label>
         <input id="token" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" value="{{ old('token', Auth::user()->phone_verity_token) }}" required>
         @if ($errors->has('token'))
            <span class="invalid-feedback"><strong>{{ $errors->first('token') }}</strong></span>
         @endif
      </div>
      <div class="form-group">
         <button type="submit" class="btn btn-primary">Save</button>
      </div>
   </form>
   <form method="POST" action="{{ route('cabinet.profile.post') }}" class="align-self-end">
      @csrf
      <div class="form-group">
         <button type="submit" class="btn btn-primary">Send message with a verify code again</button>
      </div>
   </form>
   </div>
@endsection
