
@extends('layouts.online.member')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>نسيت كلمة المرور</h3>
            <p>يمكنك إتباع الخطوات التالية لتغير كلمة المرور الخاصة بك ...</p>
        </div>
    </div>
</div>
<br>
<br>
<div id="login-content">
    <div class="content">
        <div class="login-box">
            @include('partials._errors')
            <form action="{{route('live.forgetpassword_post')}}" method="post">
                @csrf
                @method('post')
                <div class="form-group">
                    <input type="password" name="password" value="" placeholder=" New Passw0rd" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" value="" placeholder="Confirm Password"  class="form-control">
                </div>
                <div class="login-box-footer">
                    <p><button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> تغيير</button></p>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection