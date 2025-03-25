@extends('layouts.layout')
@section('content')
<div class="container">
    <h1 class="mb-5 mt-4 text-center">Reset Password</h1>
   
     @if (Session::has('error'))
    <div class="alert alert-error" role="alert">
{{Session::get('error')}}
    </div>
        
    @endif
    <form method="POST" action="{{route('resetPassword')}}">
        @csrf
        <input type="text" name="id" value="{{$user->id}}">
   <div class="mb-3">
    <label class="form-label">New Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
       @error('password')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
       @error('password_confirmation')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
   
  <button type="submit" class="btn btn-primary">Update Password</button>
</form>

</div>
@endsection

