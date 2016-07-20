@extends('admin.loginlayout')

@section('content')
<div class="form-box" id="login-box">
    @include('admin.partials.flash_message')
    @include('admin.partials.errors')
    <div class="header">Reset Password</div>
    <form action="{{ url('/password/reset') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="New Password"/>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password"/>
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
