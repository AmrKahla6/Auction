<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <title>MAZAD KW | مزاداتي</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicons
            ================================================== -->
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>

        <!-- Bootstrap -->
		<script src="{{ asset('online/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css"  href="{{ asset('online/css/bootstrap-a.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('online/fonts/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('online/fonts/font.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('online/fonts/style.css')}}">
		<link href="{{ asset('online/js/owl-carousel/owl.carousel.css')}}" type="text/css" rel="stylesheet" media="screen" />
		<link href="{{ asset('online/js/owl-carousel/owl.transitions.css')}}" type="text/css" rel="stylesheet" media="screen" />
		<script src="{{ asset('online/js/owl-carousel/owl.carousel.js')}}" type="text/javascript"></script>
		<!-- Stylesheet
            ================================================== -->
        <link rel="stylesheet" type="text/css"  href="{{ asset('online/css/style.css')}}">
		<link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">
		<script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script> 

    </head>
    <body class="clearfix wsmenucontainer">
        <div class="overlapblackbg"></div>
		<header>
		<div id="header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-xs-6">
						<a title="" class="sub-nav-menu"><span class="icon-menu1"></span></a>
						<a href="{{route('live.myonline')}}" class="logo"><img src="{{ asset('online/images/logo-header.png')}}" class="img-responsive" alt="MAZAD KW"></a>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div id="search" class="input-group">
							<input type="text" name="search" value="" placeholder="عن ماذا تبحث ..؟" class="">
							<button type="button" class=""><span class="icon-search1"></span></button>
						</div>
					</div>
					<div class="col-sm-4 hidden-xs">
						<div class="links">
						@if(!empty(App\Models\Member::find(auth()->guard('members')->id())))
					
							<a class="btn btn-add" href="{{route('live.add_auctions')}}"><span class="icon-plus-circle"></span> أضف مزاد</a>
							<a class="btn btn-myacc" href="{{route('live.profile')}}"><span class="icon-user1"></span> حسابي</a>
							<a class="btn btn-logout" href="{{route('live.logout')}}"><span class="icon-power"></span> تسجيل خروج</a>
						@else
						<a class="btn btn-login" href="{{route('live.login')}}"><span class="icon-user1"></span> الدخول</a>
						<a class="btn btn-register" href="{{route('live.register')}}"><span class="icon-user-plus1"></span> تسجيل</a>
						@endif
					</div>
					</div>
				</div>
			</div>
		</div>
		</header>
		<div class="sub-nav">
			<div class="sub-nav-content">
				<div class="content-menu">
					<ul>
						@if(!empty(App\Models\Member::find(auth()->guard('members')->id())))

						<li><a href="{{route("live.profile")}}"><span class="icon-user1"></span> حسابي</a></li>
						<li><a href="{{route("live.myonline")}}"><span class="icon-settings"></span> الرئيسية</a></li>
						<li><a href="#"><span class="icon-settings"></span> الإعدادات</a></li>
						<li><a href="{{route('live.add_auctions')}}"><span class="icon-plus-circle"></span> اضف مزاد</a></li>
						<li><a href="{{route('live.registerd')}}"><span class="icon-plus-circle"></span> مزاداتي</a></li>
						<li><a href="#"><span class="icon-heart1"></span> المفضلة</a></li>
						<li><a href="#"><span class="icon-message-circle"></span> الرسائل <span class="num">0</span></a></li>
						<li><a href="{{route('live.aboute')}}"><span class="icon-info"></span> من نحن</a></li>
						<li><a href="{{route('live.repetedquestions')}}"><span class="icon-help-circle"></span> الاسئلة المتكررة</a></li>
						<li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span> شروط الاستخدام</a></li>
						<li class="btn-logout"><a href="{{route('live.logout')}}"><span class="icon-power"></span> تسجيل خروج</a></li>
						@else
						<ul>
							<li><a href="{{route('live.login')}}"><span class="icon-user1"></span> الدخول</a></li>
							<li><a href="{{route('live.register')}}"><span class="icon-user-plus1"></span> التسجيل</a></li>
							<li><a href="{{route('live.aboute')}}"><span class="icon-info"></span> من نحن</a></li>
							<li><a href="{{route('live.repetedquestions')}}"><span class="icon-help-circle"></span> الاسئلة المتكررة</a></li>
							<li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span> شروط الاستخدام</a></li>
						</ul>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<!--  here my content -->
		@yield('content')
		@include('partials._session')
		<!-- end of content -->
		
		<div class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="links">
							<h5>معلومات</h5>
							<ul class="list-unstyled">
							  <li><a href="{{route('live.aboute')}}">من نحن</a></li>
							  <li><a href="mainfaq.html">الاسئلة المتكررة</a></li>
							  <li><a href="{{route('live.terms')}}">شروط الاستخدام</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="social">
							<h5>تابعنا على</h5>
							<div class="clearfix"></div>
							<a href="#" class="link-facebook"><i class="fa fa-facebook"></i></a>
							<a href="#" class="link-twitter"><i class="fa fa-twitter"></i></a>
							<a href="#" class="link-google-plus"><i class="fa fa-google-plus"></i></a>
							<a href="#" class="link-youtube"><i class="fa fa-youtube"></i></a>
							<a href="#" class="link-instagram"><i class="fa fa-instagram"></i></a>
							<a href="#" class="link-rss"><i class="fa fa-rss"></i></a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="apps">
							<h5>حمل التطبيق الآن</h5>
							<a href="#"><img src="{{ asset('online/images/appstore.png')}}" class="img-responsive"></a>
							<a href="#"><img src="{{ asset('online/images/googleplay.png')}}" class="img-responsive"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-copyright">جميع الحقوق محفوظة لمزاد©</div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ asset('online/js/bootstrap.min.js')}}"></script>  
	


		
<script>
	
//in case js in turned off
   $(window).on('load', function () {
        $("body").removeClass("h-fixed")
  });

$(window).scroll(function () {
     var sc = $(window).scrollTop()
    if (sc > 1) {
        $("body").addClass("h-fixed")
    } else {
        $("body").removeClass("h-fixed")
    }
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('.sub-nav-menu').on('click', function () {
        $('.sub-nav-content').toggleClass('is-active');
        $('.sub-nav-menu').toggleClass('is-active');
        $('.overlapblackbg').toggleClass('is-active');
        toggleBodyScroll();
    });
    $('.overlapblackbg').on('click', function () {
        $('.sub-nav-content').toggleClass('is-active');
        $('.sub-nav-menu').toggleClass('is-active');
        $('.overlapblackbg').toggleClass('is-active');
        toggleBodyScroll(false);
    });
});
</script>
		
		
    </body>

</html> 