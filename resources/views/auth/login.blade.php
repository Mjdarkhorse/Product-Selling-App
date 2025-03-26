@extends('layouts.layout')
@section('content')
<div class="container">
    <h1 class="mb-5 mt-4 text-center">Log In </h1>
    @if (Session::has('success'))
    <div class="alert alert-success" role="alert">
{{Session::get('success')}}
    </div>
        
    @endif
     @if (Session::has('error'))
    <div class="alert alert-error" role="alert">
{{Session::get('error')}}
    </div>
        
    @endif
    <form method="POST" action="{{route('login')}}">
        @csrf
        
  <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" >
       @error('email')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
  
   <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" >
       @error('password')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
   
  <button type="submit" class="btn btn-primary">Log In</button>
</form>
<a href="{{route('forget_Password')}}">Forget Password</a> |
<a href="{{route('mailVerificationView')}}">Mail Verification</a>

</div>
@endsection

