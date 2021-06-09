<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAZAD KW</title>
		<link href="{{ asset('online/images/icon.ico')}}" rel="icon">
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
							@if(empty(App\Models\Member::find(auth()->guard('members')->id())))
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
                            <li><a href="{{route("live.profile")}}"><span class="icon-user1"></span> @lang('live.my_acc')</a></li>
                            <li><a href="{{route("live.myonline")}}"><span class="icon-settings"></span> @lang('live.main')</a></li>
                            <li><a href="#"><span class="icon-settings"></span> @lang('live.setting')</a></li>
                            <li><a href="{{route('live.add_auctions')}}"><span class="icon-plus-circle"></span> @lang('live.add_auction')</a></li>
                            <li><a href="{{route('live.registerd')}}"><span class="icon-plus-circle"></span> @lang('live.my_auctions')</a></li>
                            <li><a href="#"><span class="icon-heart1"></span> @lang('live.my_fav') </a></li>
                            <li><a href="{{route('live.contact-us')}}"><span class="icon-message-circle"></span> @lang('live.my_msg') <span class="num">0</span></a></li>
                            <li><a href="{{route('live.aboute')}}"><span class="icon-info"></span> @lang('live.about_as')</a></li>
                            <li><a href="{{route('live.common-questions')}}"><span class="icon-help-circle"></span> @lang('live.comm_question')</a></li>
                            <li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span> @lang('live.terms')</a></li>
                            <li class="btn-logout"><a href="{{route('live.logout')}}"><span class="icon-power"></span> @lang('live.logout')</a></li>
						@else
                            <li><a href="{{route('live.login')}}"><span class="icon-user1"></span> @lang('live.l-login')</a></li>
                            <li><a href="{{route('live.register')}}"><span class="icon-user-plus1"></span> @lang('live.register')</a></li>
                            <li><a href="{{route('live.aboute')}}"><span class="icon-info"></span>@lang('live.about_as')</a></li>
                            <li><a href="{{route('live.common-questions')}}"><span class="icon-help-circle"></span>@lang('live.comm_question')</a></li>
                            <li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span>  @lang('live.terms')</a></li>
						@endif

					</ul>
				</div>
			</div>
		</div>

		<div class="slider-top">
			<div id="carousel-slider" class="owl-carousel" style="opacity: 1;">
				@if($auctions->where('is_slider',1)->count() > 0)
				@foreach ($auctions->where('is_slider',1) as  $auction)
				@if($auction->images()->count() > 0)
				<div class="text-center item">
					<a href="{{route('live.single_auction',$auction->id)}}"><img src="{{Storage::url($auction->images()->first()->img)}}" class="img-responsive" /></a>
				</div>
				@endif
				@endforeach
				@else
				<div class="text-center item">
				<a href="#"><img src="{{ asset('online/images/slider-1.png')}}" class="img-responsive" /></a>
				</div>
				<div class="text-center item">
					<a href="#"><img src="{{ asset('online/images/slider-2.png')}}" class="img-responsive" /></a>
				</div>
				<div class="text-center item">
					<a href="#"><img src="{{ asset('online/images/slider-3.png')}}" class="img-responsive" /></a>
				</div>
				@endif
			</div>

			<script>
			$('#carousel-slider').owlCarousel({
				items: 1,
				itemsDesktop : [1199,1],
				itemsDesktopSmall : [980,1],
				itemsTablet: [768,1],
				itemsTabletSmall: false,
				itemsMobile : [479,1],
				autoPlay: 3000,
				navigation: true,
				navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
				pagination: true
			});
			</script>
		</div>
		<div class="categories">
		 @include('online.categories');
		</div>
		<div class="products">
			<div class="products-title">
				<div class="container">
					<div class="head-title">
						<h3>أحدث المزادات القائمة</h3>
						<p>أحدث المزادات في مختلف الأقسام</p>
					</div>
					@if($auctions->count() > 0)
					<span class="count-products">{{$auctions->count()}}  مزاد قائم </span>
					@else
					<span class="count-products"> ليس هناك مزادات قائمة  </span>

					@endif
				</div>
			</div>
			<div class="container">
				<div class="row">
					@if($auctions->count() > 0)
						 @foreach ($auctions as  $auction)
					<div class="col-md-4 col-sm-6 col-xs-12">
						<a href="{{route('live.single_auction',$auction->id)}}" id="product-{{$auction->id}}" class="product">
							<div class="image">

								@if($auction->images()->count() > 0)
                                    <img src="{{asset('uploads/acution/'.$auction->images()->first()->img)}}" class="img-responsive" />
								@else
								    <img src="{{ asset('online/images/Upload/img-1.jpg')}}" class="img-responsive" />
								@endif

								<p class="price">{{$auction->price_opining}} درهم</p>
								@if (Auth::guard('members')->user())
									<div class="addtofavorite" data-id="{{ $auction->id}}">
										<input value="" type="checkbox" id="add-favorite-id01" name="is_like" class="favorite-input">
										<input type="hidden" id="member_id" name="member_id" value="{{isset(Auth::guard('members')->user()->id) ? Auth::guard('members')->user()->id : ""}}">
										<label for="add-favorite-{{$auction->id}}" title="أضف للمفضلة">
											<i id="heart-{{$auction->id}}" class="fa fa-heart-o"></i>
										</label>
									</div>
								@else
									<div class="addtofavorite">
										<input value="" type="checkbox" disabled class="favorite-input">
										<label disabled title="قم بتسجيل الدخول">
											<i disabled class="fa fa-heart-o"></i>
										</label>
									</div>
								@endif
							</div>
							<div class="product-detials">
								<p class="time">{{$auction->start_data}} <span>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $auction->created_at)->diffForHumans()}}</span></p>
								<h3 class="product-name">{{$auction->auction_title}}</h3>
								<div class="timer"><span class="icon-alarm"></span> <p id="timer-{{$auction->id}}"></p></div>
								<script>

								// Set the date we're counting down to
								var countDownDate = new Date("{{$auction->end_data}}").getTime();
								// Update the count down every 1 second
								var x = setInterval(function() {

								  // Get today's date and time
								  var now = new Date().getTime();

								  // Find the distance between now and the count down date
								  var distance = countDownDate - now;

								  // Time calculations for days, hours, minutes and seconds
								  var days    = Math.floor(distance / (1000 * 60 * 60 * 24));
								  var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
								  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

								  document.getElementById("timer-{{$auction->id}}").innerHTML = days + "<span>ي</span> " + hours + "<span>س</span> "
								  + minutes + "<span>د</span> " + seconds + "<span>ث</span> ";

								  // If the count down is over, write some text
								  if (distance < 0) {
									clearInterval(x);
									document.getElementById("timer-{{$auction->id}}").innerHTML = "<font color='#e72727'>EXPIRED</font>";
								  }
								}, 1000);
								</script>
							</div>
						</a>
					</div>

					@endforeach
				@endif

				</div>
			</div>
		</div>


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

        <script type="text/javascript" src="{{ asset('online/js/wow.min.js')}}"></script>

        <!-- Javascripts
            ================================================== -->
        <script type="text/javascript" src="{{ asset('online/js/main.js')}}"></script>

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
{{-- <script type="text/javascript">
$(document).ready(function() {
    if ($('.favorite-input').is(':checked')) {
		$('.overlapblackbg').after('<div class="completeModal">'تم تم تم '</div>');
        } else {
		$('.overlapblackbg').after('<div class="completeModal">'متمش متمش متمش '</div>');
    });
});
</script> --}}

<script>
	//Favorit Ajax
   $(document).ready(function() {
    $('.addtofavorite').on('click', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var member_id  = $('#member_id').attr('name');
        var auction_id =  $(this).data('id');
        var is_like    = $('#add-favorite-id01').attr('name');
        $.ajax({
            type:"POST",
			url:"live/add-favorite/"+auction_id,
            data:{
                member_id  : member_id,
                auction_id : auction_id,
                is_like    : is_like ,
                _token:"{{ csrf_token() }}"},
            dataty:"json",
            cache: false,

            success:function (data) {
                if(data.status= true){
                    if(data.favorite.is_like == 1){
						$('#heart-'+auction_id).replaceWith('<i class="fa fa-heart"></i>');
                    }else{
						$('#heart-'+auction_id).replaceWith('<i class="fa fa-heart-o"></i>');
					}

				}
            }
        })
    });
   });
</script>
    </body>

</html>
