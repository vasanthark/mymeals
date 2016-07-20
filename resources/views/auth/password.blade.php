@extends('admin.loginlayout')

@section('content')
<div class="form-box" id="login-box">
    @include('admin.partials.flash_message')
    @include('admin.partials.errors')
    <div class="header">Forgot Password</div>
    <form action="{{ url('/password/email') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus/>
            </div>           
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">Submit</button>
            <p><a href="{{ url('/auth/login') }}">Back</a></p>
            <!--<a href="register.html" class="text-center">Register a new membership</a>-->
        </div>
    </form>
</div>
@endsection
