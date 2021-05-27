@extends('layouts.online.member')
@section('content')
<div class="container">
    <div id="profile-page">
        <div class="profile-head">
            <a class="link-setting" href="setting.html"><span class="icon-settings"></span></a>
            <div class="about">
                <div class="image">
                    <img src="{{ asset('online/js/images/user.png')}}" class="img-responsive" />
                </div>
                <div class="content">
                    <div class="username">{{$member->username}}</div>
                    <div class="mail">{{$member->email}}</div>
                </div>
            </div>
            <div class="numbers">
                <div>
                    <b>{{$member->tenders()->count()}}</b>
                    <p>مزايدة</p>
                </div>
                <div>
                    <b>{{$member->auctions()->where('is_finished',0)->count()}}</b>
                    <p>مزاد حالي</p>
                </div>
                <div>
                    <b>{{$member->auctions()->where('is_finished',1)->count()}}</b>
                    <p>مزاد منتهي</p>
                </div>
            </div>
            <div class="balance">
                <div class="content">
                    <p>محفظتي</p>
                    <b>350 درهم</b>
                </div>
                <button type="button" class="btn btn-balance" data-toggle="modal" data-target="#buy_credit_modal">شراء رصيد</button>
            </div>
        </div>
        <div class="profile-links">
            <a href="{{route('live.my_tenders')}}"><span class="icon-activity"></span> مزايداتي</a>
            <a href="{{route('live.registerd')}}"><span class="icon-share"></span> مزاداتي</a>
            <a href="#"><span class="icon-heart1"></span> المفضلة</a>
            <a href="#"><span class="icon-bell1"></span> الاشعارات <span class="num">0</span></a>
            <a href="contactus.html"><span class="icon-headphones"></span> اتصل بنا</a>
            <a href="about.html"><span class="icon-info"></span> من نحن</a>
            <a href="mainfaq.html"><span class="icon-help-circle"></span> الاسئلة المتكررة</a>
            <a href="terms.html"><span class="icon-alert-triangle"></span> شروط الاستخدام</a>
            <a class="btn-logout" href="#"><span class="icon-power"></span> تسجيل خروج</a>
        </div>
    </div>
    
<div class="modal fade" id="buy_credit_modal" tabindex="-1" role="dialog" aria-labelledby="buy_credit_modalTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="buy_credit_modalTitle">محفظتي
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span class="icon-x"></span>
</button>
</h5>
</div>
<div class="modal-body">
  <h3><span class="icon-wallet"></span> رصيد محفظتي</h3>
  <div class="mycredit">
      <p>رصيدي المتاح</p>
      <b>35 درهم</b>
  </div>
  <h3>شحن محفظتي</h3>
  <input type="text" name="add_credit" value="" placeholder="اكتب قيمة الشحن" id="add_credit" class="form-control">
  <button type="button" class="btn btn-primary">شحن</button>
</div>
</div>
</div>
</div>	
    
    
    
</div>
@endsection