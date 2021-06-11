@extends('layouts.online.member')
@section('content')
		<div class="page-title">
			<div class="container">
				<div class="head-title">
					<h3> @lang('live.edit_profile')</h3>
					<p>@lang('live.edit_acc')</p>
				</div>
			</div>
		</div>
		<div id="login-content">
			<div class="content">
			<div class="tab-content">
                    <div>
                        <div class="login-box">
                            @include('partials._errors')
                            @include('partials._session')
                            <form action="{{route('live.save-change-password')}}" method="post" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="password"  name="password"  placeholder="@lang('live.old_pass')" id="input-username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="password"  name="new_password"  placeholder="@lang('live.new_pass')" id="input-username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="password"  name="password_confirmation"  placeholder="@lang('live.con-password')" id="input-username" class="form-control">
                                </div>

                                <div class="login-box-footer">
                                    <button type="submit"  class="btn btn-block btn-lg btn-primary">@lang('live.edit_profile')</button>
                                </div>
                            </form>
                        </div>
                    </div>
			</div>


			</div>
		</div>

 @endsection
