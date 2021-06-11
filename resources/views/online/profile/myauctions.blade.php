<div class="auctions-tabs">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#present">@lang('live.current_auct')</a></li>
            <li><a data-toggle="tab" href="#finished">@lang('live.finish_auct')</a></li>
        </ul>
    </div>
</div>
<div class="tab-content">
    <div id="present" class="tab-pane in active">
        <div class="products">
            <div class="container">
				<div class="row">
					@if($auctions_active->count() > 0)
					 @foreach ($auctions_active as  $auction)
					 <div class="col-md-4 col-sm-6 col-xs-12">
						<a href="{{route('live.single_auction',$auction->id)}}" id="product-{{$auction->id}}" class="product">
							<div class="image">
								@if($auction->images()->count() > 0)

								    <img src="{{asset('uploads/acution/'.$auction->images()->first()->img)}}" class="img-responsive" />
								@else
								    <img src="{{ asset('online/images/Upload/img-1.jpg')}}" class="img-responsive" />
								@endif
								<p class="price">{{$auction->price}} @lang('live.dirhams')</p>
								<div class="addtofavorite">
									@if(App\Models\favorite::is_favorite($auction->id)==true)
									<input value="" type="checkbox" id="add-favorite-{{$auction->id}}" name="add-favorite-{{$auction->id}}" class="favorite-input" checked>
										<label for="add-favorite-{{$auction->id}}"  title="@lang('live.add_favorit')">
										<i class="fa fa-heart-o" ></i>
										@else
										<input value="" type="checkbox" id="add-favorite-{{$auction->id}}" name="add-favorite-{{$auction->id}}" class="favorite-input">
										<label for="add-favorite-{{$auction->id}}"title="@lang('live.add_favorit')">
										<i class="fa fa-heart-o" ></i>
									</label>
									@endif
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
				@endif

				</div>
			</div>
        </div>
    </div>
    <div id="finished" class="tab-pane">
        <div class="products">
            <div class="container">
				<div class="row">
					@if($auctions_dis->count() > 0)
					 @foreach ($auctions_dis as  $auction)
					 <div class="col-md-4 col-sm-6 col-xs-12">
						<a href="product.html" id="product-id01" class="product">
							<div class="image">
								@if($auction->images()->count() > 0)
								    <img src="{{asset('uploads/acution/'.$auction->images()->first()->img)}}" class="img-responsive" />
								@else
								    <img src="{{ asset('online/images/Upload/img-1.jpg')}}" class="img-responsive" />
								@endif
								<p class="price">{{$auction->price}} @lang('live.dirhams')</p>
								<div class="addtofavorite">
									<input value="" type="checkbox" id="add-favorite-id01" name="add-favorite-id01" class="favorite-input">
									<label for="add-favorite-id01" title="@lang('live.add_favorit')">
										@if(App\Models\Favorite::is_favorite($auction->id)==true?dd(App\Models\Favorite::is_favorite($auction->id)):App\Models\Favorite::is_favorite($auction->id))@endif
										<i class="fa fa-heart-o">

										</i>

									</label>
								</div>
							</div>
							<div class="product-detials">
								<p class="time">{{$auction->start_data}} <span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $auction->created_at)->diffForHumans()}}</span></p>
								<h3 class="product-name">{{$auction->auction_title}}</h3>
								<div class="timer"><span class="icon-alarm"></span> <p id="timer-{{$auction->id}}"></p></div>
								<script>

								// Set the date we're counting down to
								var countDownDate = new Date("{{$auction->end_data}}").getTime();
								// Update the count down every 1 second
								var x = setInterval(function() {
								  // Get today's date and time
								  var now =  new Date().getTime();
								  // Find the distance between now and the count down date
								  var distance = countDownDate - now;

								  // Time calculations for days, hours, minutes and seconds
								var days = Math.floor(distance / (1000 * 60 * 60 * 24));
								var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
								var seconds = Math.floor((distance % (1000 * 60)) / 1000);

								  document.getElementById("timer-{{$auction->id}}").innerHTML = days + "<span>ي</span> " + hours + "<span>س</span> "
								  + minutes + "<span>د</span> " + seconds + "<span>ث</span> ";
                                   // console.log(distance);
								  // If the count down is over, write some text
								  if (distance <= 0) {
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
    </div>
</div>

