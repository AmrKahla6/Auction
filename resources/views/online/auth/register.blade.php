@extends('layouts.online.visitor')
@section('content')
		<div class="page-title">
			<div class="container">
				<div class="head-title">
					<h3> @lang('live.new_acc')</h3>
					<p>@lang('live.have_acc')</p>
				</div>
			</div>
		</div>
		<div id="login-content">
			<div class="content">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#person">@lang('live.regular_acc')</a></li>
				<li><a data-toggle="tab" href="#facility"> @lang('live.commercial_acc')</a></li>
			</ul>
			<div class="tab-content">
				<div id="person" class="tab-pane fade in active">
					<div class="login-box">
                        @include('partials._errors')
						<form action="{{route('live.register')}}" method="post" autocomplete="off">
							@csrf
							@method('post')
							<div class="form-group">
								<input type="text"  name="username"  placeholder="@lang('live.username')" id="input-username" class="form-control" value="{{ old('username') }}">
							</div>
							<div class="form-group">
								<input type="tel"  required="required"  name="phone"  placeholder="@lang('live.phone')" id="input-phone" class="form-control" value="{{ old('phone') }}">
							</div>
							<div class="form-group">
								<input type="date"  required="required" name="date_of_birth" title="@lang('live.input-date')"  placeholder="تاريخ الميلاد" id="input-date" class="form-control" value="{{ old('date_of_birth') }}">
							</div>
							<div class="form-group">
								{{-- <input type="text" name="nationality"  placeholder="@lang('live.nationality')" id="input-nationality" class="form-control" value="{{ old('date_of_birth') }}"> --}}
                                <select name="country_id" class="form-control" required>
                                    <option selected disabled value="choose">@lang('live.nationality')</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}">{{$country->country_name}}</option>
                                    @endforeach
                                </select>
							</div>
							<div class="form-group">
								<input type="text"  required="required" name="email"  placeholder="@lang('live.email')" id="input-email" class="form-control" value="{{ old('email') }}">
							</div>
							<div class="form-group">
								<input type="password"  required="required" name="password"  placeholder="@lang('live.password')" id="input-password" class="form-control" >
							</div>
							<input type="hidden" name="type" value="0">
							<div class="login-box-footer">
								<button type="submit"  class="btn btn-block btn-lg btn-primary">@lang('live.register')</button>
								<div class="text-hr"><span>@lang('live.or')</span></div>
								<p><a href="{{route('live.login')}}" class="link-register">@lang('live.login')</a></p>
							</div>
						</form>
					</div>
				</div>



				<div id="facility" class="tab-pane fade">
					<div class="login-box">
                        @include('partials._errors')
						<form action="{{route('live.commercial-register')}}" method="post" autocomplete="off">
							@csrf
							@method('post')
							<div class="form-group">
								<input type="number"  required="required" name="commercial_record"  placeholder="@lang('live.commercial')" value="{{ old('commercial_record') }}" id="input-commercial_record" class="form-control">
							</div>
							<div class="form-group">
								<input type="tel"  required="required" name="phone"  placeholder="@lang('live.phone')" value="{{ old('phone') }}" id="input-phone" class="form-control">
							</div>
							<div class="form-group">
								<input type="date"  required="required" name="date_of_birth" title="@lang('live.input-date')"  value="{{ old('date_of_birth') }}" placeholder="تاريخ الميلاد" id="input-date" class="form-control" value="{{ old('date_of_birth') }}">
							</div>
							<div class="form-group">
								<input type="number"  required="required" name="id_number"  placeholder="@lang('live.id_number')" value="{{ old('id_number') }}" id="input-identity_number" class="form-control">
							</div>
							<div class="form-group">
								<input type="text" name="email"  placeholder="@lang('live.email')" value="{{ old('email') }}" id="input-email" class="form-control">
							</div>
							<div class="form-group">
								<input type="password"  required="required" name="password"  placeholder="@lang('live.password')" id="input-password" class="form-control">
							</div>

							<div class="login-box-footer">
								<button type="submit" class="btn btn-block btn-lg btn-primary">@lang('live.register')</button>
								<div class="text-hr"><span>@lang('live.or')</span></div>
								<p><a href="{{route('live.login')}}" class="link-register"> @lang('live.login')</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>


			</div>
		</div>

 @endsection
