@extends('layouts.online.visitor')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>تسجيل الدخول</h3>
            <p>إذا كنت تملك حساب مسبق في الموقع، فتفضل بتسجيل دخولك...</p>
        </div>
    </div>
</div>
<div id="login-content">
    <div class="content">
        <div class="login-box">
            <form action="{{route('live.login_post')}}" method="post">
                @csrf
                @method('post')
                <div class="form-group">
                    <input type="tel" name="phone"  value="" placeholder="رقم الهاتف" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="password" value="" placeholder="كلمة المرور" required="required" class="form-control">
                </div>
                <a class="forget" href="{{route('live.forgetpassword')}}">نسيت كلمه المرور؟</a>
                <div class="login-box-footer">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">تسجيل الدخول</button>
                    <div class="text-hr"><span>أو</span></div>
                    <p><a href="{{route('live.register')}}" class="link-register">تسجيل الأن</a></p>
                    <p><a href="{{route('live.myonline')}}" class="link-skip"><i class="fa fa-arrow-right"></i> تخطي</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
