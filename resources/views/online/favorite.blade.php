@extends('layouts.online.member')
@section('content')

		<div class="products">
			<div class="products-title">
				<div class="container">
					<div class="head-title">
						<h3>@lang('live.my_fav')</h3>
						<p>@lang('live.auction_fav')</p>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
                    @if ($my_fav->count() > 0)
                        @foreach ($my_fav as $item)
                            <div class="col-md-4 col-sm-6 col-xs-12" id="Div-{{$item->auction->id}}">
                                <a  id="product-{{$item->auction->id}}" class="product">
                                    <div class="image">
                                        <img src="{{asset('uploads/acution/'.$item->auction->images->first()->img)}}" class="img-responsive" />
                                        <p class="price">{{$item->auction->price_opining}} @lang('live.dirhams')</p>
                                        <div class="addtofavorite" data-id="{{$item->auction->id}}">
                                            <input value="" type="checkbox" id="add-favorite-{{$item->auction->id}}"  name="is_like" class="favorite-input" checked>
                                            <input type="hidden" id="member_id" name="member_id" value="{{isset(Auth::guard('members')->user()->id) ? Auth::guard('members')->user()->id : ""}}">
                                            <label for="add-favorite-{{$item->auction->id}}" title="@lang('live.add_favorit')">
                                                <i id="heart-{{$item->auction->id}}" class="fa fa-heart-o"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="product-detials">
                                        <p class="time">{{$item->auction->start_data}} <span>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->auction->created_at)->diffForHumans()}}</span></p>
                                        <h3 class="product-name">{{$item->auction->auction_title}}</h3>
                                        <div class="timer"><span class="icon-alarm"></span> <p id="timer-{{$item->auction->id}}"></p></div>
                                        <script>

                                        // Set the date we're counting down to
                                        var countDownDate = new Date("{{$item->auction->end_data}}").getTime();
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

                                        document.getElementById("timer-{{$item->auction->id}}").innerHTML = days + "<span>ي</span> " + hours + "<span>س</span> "
                                        + minutes + "<span>د</span> " + seconds + "<span>ث</span> ";

                                        // If the count down is over, write some text
                                        if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("timer-{{$item->auction->id}}").innerHTML = "<font color='#e72727'>EXPIRED</font>";
                                        }
                                        }, 1000);
                                        </script>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                       <center> <h1>@lang('live.no_favorits')</h1></center>
                    @endif

				</div>
			</div>
		</div>
<script>
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
        var is_like    = $("#add-favorite-"+auction_id).attr('name');
        
        $.ajax({
              type:"post",
                url:"{{route('live.add_favorite')}}",
                _token:"{{ csrf_token()}}",
            data:{
                member_id  : member_id,
                auction_id : auction_id,
                is_like    : is_like ,
                _token:"{{ csrf_token() }}"},
            dataty:"json",
            cache: false,
            success:function (data) {
                if(data.status= true){
                  $("#Div-"+auction_id).html("")


				}
            }
        })
    });
   });
</script>
        <script type="text/javascript" src="{{ asset('js/favorite.js')}}"></script>

@endsection

