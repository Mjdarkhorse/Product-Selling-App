@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<div class="container">
    <h1 class="mb-5 mt-4 text-center">Register</h1>
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
    <form method="POST" action="{{route('register')}}">
        @csrf
        <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" >
    @error('name')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" >
       @error('email')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="hidden" name="code" id="code">
    <br>
    <input type="text" class="form-control" maxlength="10" id="phone" value="{{old('phone')}}" name="phone" placeholder="Enter Phone No" >
       @error('phone')
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
   <div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" >
       @error('password_confirmation')
        <span class="error-massage">{{$message}}</span>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
</div>
@endsection

@push('script')
<script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "IN",
            separateDialCode: true,
            utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        $(document).ready(function(){
            $('#code').val('+'+phoneInput.s.dialCode);
            //for end country code mobile
            const errorMap = [":- Invalid phone number", ":- Invalid country code", ":- Phone Number is Too short", ":- Phone Number is Too long", ":- Invalid phone number"];
            $('#phone').keyup(function(){

                $('#code').val('+'+phoneInput.s.dialCode);

            });

            $('.iti__flag-container').click(function(){
                $('#code').val('+'+phoneInput.s.dialCode);
            });
        });

    </script>
    
@endpush