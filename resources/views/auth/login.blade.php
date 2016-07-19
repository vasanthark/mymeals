@extends('admin.loginlayout')

@section('content')
<div class="form-box" id="login-box">
    @include('admin.partials.errors')
    @include('admin.partials.flash_message')
    <div class="header">Sign In</div>
    <form action="{{ url('/auth/login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" autofocus/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>
<!--            <div class="form-group">
                <input type="checkbox" name="remember"/> Remember me
            </div>-->
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">Sign in</button>
            <!--<p><a href="{{URL::to('password/reset')}}">I forgot my password</a></p>-->
            <!--<a href="register.html" class="text-center">Register a new membership</a>-->
        </div>
    </form>
</div>
@endsection