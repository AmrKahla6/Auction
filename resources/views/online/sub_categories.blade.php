@section('content')
@extends('layouts.online.member')
		<div class="sub-categories">
			<div class="container">
				<ul class="mb-3 nav nav-pills" id="pills-tab" role="tablist">
                    @foreach ($categories as $index=>  $cat)
					   @if($index < 1)
                            <li class="nav-item active">
                                <a class="nav-link active" id="pills-{{$cat->id}}-tab" data-toggle="pill" href="#pills-{{$cat->id}}" role="tab" aria-controls="pills-{{$cat->id}}" aria-selected="true">
                                    @if (App::isLocale('en'))
                                        {{$cat->category_name_en}}
                                    @else
                                        {{$cat->category_name_ar}}
                                    @endif
                                </a>
                            </li>
					    @else
                        <li class="nav-item">
                            <a class="nav-link" id="pills-{{$cat->id}}-tab" data-toggle="pill" href="#pills-{{$cat->id}}" role="tab" aria-controls="pills-{{$cat->id}}"  aria-selected="false">
                                @if (App::isLocale('en'))
                                    {{$cat->category_name_en}}
                                @else
                                    {{$cat->category_name_ar}}
                                @endif
                            </a>
                        </li>
					   @endif
                    @endforeach

				</ul>
			</div>
		</div>
		<div class="products">
			<div class="container">
		  <div class="row">
		    <div class="tab-content" id="pills-tabContent">
				@foreach ($categories as $index =>  $cat)
					@if($index< 1)
					    <div class="tab-pane fade show active in" id="pills-{{$cat->id}}" role="tabpanel" aria-labelledby="pills-{{$cat->id}}-tab">
					@else
					    <div class="tab-pane fade show" id="pills-{{$cat->id}}" role="tabpanel" aria-labelledby="pills-{{$cat->id}}-tab">
					@endif
                      @foreach ($cat->auctions()->get() as $auction )
					  <div class="col-md-4 col-sm-6 col-xs-12">
						<a href="{{route('live.single_auction',$auction->id)}}" id="product-id{{$auction->id}}" class="product">
							<div class="image">
								@if($auction->images()->count() > 0)
								<img src="{{asset('uploads/acution/'.$auction->images()->first()->img)}}" class="img-responsive" />
								@else
								<img src="{{asset('online/images/Upload/img-1.jpg')}}" class="img-responsive" />
								@endif
								<p class="price">{{$auction->price_opining}} @lang('live.dirhams')</p>
								<div class="addtofavorite">
									<input value="" type="checkbox" id="add-favorite-id{{$auction->id}}" name="add-favorite-id01" class="favorite-input">
									<label for="add-favorite-id{{$auction->id}}" title="@lang('live.add_favorit')">
										<i class="fa fa-heart-o"></i>
									</label>
								</div>
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
			      </div>
				  @endforeach
		  </div>

				</div>
			</div>
		</div>


@endsection
