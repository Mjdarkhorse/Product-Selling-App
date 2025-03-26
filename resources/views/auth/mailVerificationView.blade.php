@extends('layouts.layout')
@section('content')
<div class="container">
    <h1 class="mb-5 mt-4 text-center">Mail Verification</h1>
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
    <form method="POST" action="{{route('mailVerification')}}">
        @csrf
        
  <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" >
       @error('email')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
@endsection

