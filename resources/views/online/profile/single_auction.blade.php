
@extends('layouts.online.member')
@section('content')
<div id="product-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="product-images">
                    <div id="product-images" class="owl-carousel" style="opacity: 1;">
                        @if($auction->images()->count() > 0)
                          @foreach ( $auction->images()->get() as $image)
                            <div class="text-center item">
                                <img src="{{asset('uploads/acution/'.$image->img)}}" class="img-responsive" />
                            </div>
                          @endforeach
                        @endif
                    </div>
                    <div class="expiry_date">الإنتهاء {{$auction->end_data}}</div>
                    <script>
                    $('#product-images').owlCarousel({
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
            </div>
            <div class="col-sm-6">
                <div class="product-detials">
                    <p class="time">23 سبتمبر 2021  <span>منذ 50:04</span></p>
                    <h3 class="product-name">{{$auction->auction_title}}</h3>
                    <div class="timer"><span class="icon-alarm"></span> <p id="timer-id09"></p></div>
                    <p class="opening_price">السعر الإفتتاحي <strong>{{$auction->price_opining}} درهم</strong></p>
                    <div>
                        <table class="table table-bordered">
                            <tr>
                                <td>أعلى سعر مزاد</td>
                                <td class="text-right text-cred"><strong>{{$auction->price}} درهم</strong></td>
                            </tr>
                            <tr>
                                <td>أقل سعر مزاد</td>
                                <td class="text-right"><strong>{{$auction->price_opining}} درهم</strong> <span class="icon-info"></span></td>
                            </tr>
                        </table>
                    </div>
                    @if(Auth::guard('members')->user()->id == $auction->member_id)
                        <button type="button" disabled title="@lang('live.can_not_auction')" class="btn btn-danger btn-lg btn-block"> مزادك</button>
                     @elseif(Auth::guard('members')->check())
                     @if ($auction->is_finished == 1)
                        <button type="button" disabled title="مزاد منتهي" class="btn btn-danger btn-lg btn-block">مزايدة منتهي</button>
                     @else
                        <button type="button" id="bid_now" onclick="$('#form-bid_now').toggleClass('hide'); $(this).toggleClass('hide')" class="btn btn-primary btn-lg btn-block">مزايدة الآن</button>
                     @endif
                    @endif

                    @include('partials._errors')
                    @include('partials._session')
                    <form action="{{route('live.add_tender',$auction->id)}}" method="post">
                        @method('POST')
                        @csrf
                        <div id="form-bid_now" class="hide">
                            <div class="form-title"><h3><span class="icon-wallet"></span> قيمة المزايدة</h3></div>
                            <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="أكتب قيمة المزايدة" id="input-bid" class="form-control">
                            {{-- <input value="{{$auction->id}}" id="aucation_id" class="hide"> --}}
                            <p class="alert_text">يرجى العلم ان الحد الادنى للمزايدة هو <span>{{$auction->price_opining}} </span></p>
                            <div class="form-title"><h3><span class="icon-wallet"></span> مصاريف الإشتراك</h3></div>
                            <div class="subscription_fee">
                                <div class="sub_fee_text">
                                    <p>الإشتراك في المزايدة</p>
                                    <b>سيتم خصم</b>
                                </div>
                                <div class="sub_value">
                                    <p>35 <span>درهم</span></p>
                                </div>
                            </div>
                            <div class="terms_conditions">
                                <p>الموافقة على الشروط والاحكام</p>
                                <input value="" type="checkbox" id="terms-input" name="terms-input" class="terms-input" checked>
                                <label for="terms-input" title="الموافقة على الشروط والاحكام">
                                    <span class="fa fa-toggle-on"></span>
                                </label>
                            </div>
                            <button type="submit" id="add_now" class="btn btn-primary btn-lg btn-block">أشترك الآن</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="product-about">
                    <div class="text-title">
                        <h3>وصف المعلن</h3>
                    </div>
                    <div class="content">
                        <p>{{$auction->desc_ar}}</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="product-owner">
                    <div class="text-title">
                        <h3>مواصفات المعلن للإعلان</h3>
                    </div>
                    <div class="content">
                        <div class="box-detials">
                            @if($auction->more_detials()->count() > 0)

                              @foreach ( $auction->more_detials()->get() as $detail)
                              @if($detail->type_id ==1)
                              <div class="col-xs-6">
                                <div class="box-ico"><img src="images/002-meter.png" class="img-responsive" /></div>
                                <div class="box-content">
                                    <p>{{$detail->cat_parm()->first()->param_name_ar}}</p>
                                    <p>{{$detail->param_value}}</p>

                                </div>
                            </div>
                            @elseif($detail->type_id ==2)
                            <div class="col-xs-6">
                                <div class="box-ico"><img src="images/002-meter.png" class="img-responsive" /></div>
                                <div class="box-content">
                                    <p>{{$detail->param()->first()->param()->first()->param_name_ar}}</p>
                                    <p>{{$detail->param_value}}</p>

                                </div>
                            </div>
                            @endif
                             @endforeach
                            @endif
                        </div>
                        <div id="owner-about">
                            <div class="image">
                                <img src="{{ asset('online/images/user.png')}}" class="img-responsive" />
                            </div>
                            <div class="owner-about">
                                <p class="name">{{$auction->member->username}}</p>
                                <p class="mail">{{$auction->member->email}}</p>
                                <p id="phone-num" class="phone">{{$auction->member->phone}}</p>
                            </div>
                            <a onclick="myPhoneNum()" class="phone-num"><span class="icon-phone"></span></a>
                        </div>
                        <div class="owner-location"><span class="icon-location1"></span> <p></p></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="tenders">
                    <div class="head-title">
                        <h3>أحدث المزايدات</h3>
                        <p>إجمالي {{$auction->tenders()->count()}}</p>
                    </div>
                    <a class="count-tenders">جميع المزايدات</a>
                    <div class="tenders-boxs">
                        @if($auction->tenders()->count() > 0)
                          @foreach ($auction->tenders()->get() as $tender )
                        <div class="tender-box">
                            <p class="name">{{$tender->member->username}}</p>
                            <div class="detials">
                                <div class="bid-id">رقم المزايدة<p>{{$tender->id}}</p></div>
                                <div class="bid-value">
                                    <p>قيمة المزايدة</p>
                                    <strong>{{$tender->price}}</strong>
                                </div>
                            </div>
                            <p class="date">{{$tender->created_at}}</p>
                        </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function myPhoneNum() {
      var x = 0123456789;
      document.getElementById("phone-num").innerHTML = x;
    }
    </script>
    {{-- <script type="text/javascript">
    $(document).ready(function() {
        $('#add_now').on('click', function () {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var price= $("#price").val();
            var aucation_id = $("#aucation_id").val();
         if(Number(price)> 0){
           $.ajax({
			type:"POST",
			url:"/live/add_tender",
			data:{
            price:price,
            aucation_id:aucation_id,
            _token:"{{ csrf_token() }}"},
			dataty:"json",
            cache: false,
			success:function (data) {
         if(data.msg="success"){
         $('#product-page').after('<div class="completebg"></div><div class="completeModal"><div class="big-icon"><i class="fa fa-check-circle"></i></div><h4>تمت المزايدة بنجاح</h4><p>مبلغ المزايدة <strong>'+data.price+' درهم</strong></p><p>رقم المزايدة <strong>'+data.id+'</strong></p><a href="{{route("live.myonline")}}">العودة للرئيسية</a></div>');
          //toggleBodyScroll();
             }
			/*	Swal.fire({
					titel:'Success add Question!',
				   text: 'You clicked the button!',
				   type:'success'
				});*/


			} ,
			error:function (error) {

            }

     	});
    }
        });

    });
    </script> --}}
@endsection
