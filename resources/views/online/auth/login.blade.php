@extends('layouts.online.visitor')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>@lang('live.login')</h3>
            <p>@lang('live.have_acc')</p>
        </div>
    </div>
</div>
<div id="login-content">
    <div class="content">
        <div class="login-box">
            @include('partials._errors')
            @include('partials._session')
            <form action="{{route('live.login_post')}}" method="post">
                @csrf
                @method('post')
                <div class="form-group">
                    <input type="tel" name="phone"  placeholder="@lang('live.phone')"  value="{{ old('phone') }}" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="password"  placeholder="@lang('live.password')" required="required" class="form-control">
                </div>
                <a class="forget" href="{{route('live.forgetpassword')}}">@lang('live.forgtpass')</a>
                <div class="login-box-footer">
                    <button type="submit" class="btn btn-block btn-lg btn-primary"> @lang('live.login')</button>
                    <div class="text-hr"><span>@lang('live.or')</span></div>
                    <p><a href="{{route('live.register')}}" class="link-register">@lang('live.login_now')</a></p>
                    <p><a href="{{route('live.myonline')}}" class="link-skip"><i class="fa fa-arrow-right"></i> @lang('live.skip')</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
