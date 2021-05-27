
@extends('layouts.online.visitor')
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
            <form>
                <div class="form-group">
                    <input type="tel" name="phone" value="" placeholder="رقم الهاتف" id="input-phone" class="form-control">
                </div>
                <div class="login-box-footer">
                    <button type="button" class="btn btn-block btn-lg btn-primary">متابعة</button>
                    <div class="text-hr"><span>أو</span></div>
                    <p><a href="{{route('live.login')}}" class="link-register">حاول مرة اخرى</a></p>
                    <p><a href="{{route('live.myonline')}}" class="link-skip"><i class="fa fa-arrow-right"></i> تخطي</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
@endsection