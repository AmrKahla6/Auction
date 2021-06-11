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
			<ul class="nav nav-tabs">
                @if ($member->type == 1)
				    <li class="active"><a href="#person">@lang('live.regular_acc')</a></li>
                @else
				    <li><a  href="#facility"> @lang('live.commercial_acc')</a></li>
                @endif
			</ul>
			<div class="tab-content">
                @if ($member->type == 1)
                    <div>
                        <div class="login-box">
                            @include('partials._errors')
                            <form action="{{route('live.edit-normal-profile')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="text"  name="username" value="{{$member->username}}" placeholder="@lang('live.username')" id="input-username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="date"  required="required" value="{{$member->date_of_birth}}" name="date_of_birth" title="@lang('live.input-date')"  placeholder="تاريخ الميلاد" id="input-date" class="form-control" >
                                </div>

                                <div class="form-group">
                                    {{-- <input type="text" name="nationality"  placeholder="@lang('live.nationality')" id="input-nationality" class="form-control" value="{{ old('date_of_birth') }}"> --}}
                                    <select name="country_id" class="form-control" required>
                                        <option selected disabled value="choose">@lang('live.nationality')</option>
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}" {{(old('country_id', $member->country_id) == $country->id ? 'selected' : '')}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" value="{{$member->email}}"   required="required" name="email"  placeholder="@lang('live.email')" id="input-email" class="form-control" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    @if ($member->img)
                                        <img src="{{ asset('uploads/members/'.$member->img) }}"
                                        class="img-thumbnail image-preview" style="width: 100px;">
                                    @else

                                        <img src="{{ asset('uploads/members/default.png') }}"
                                            class="img-thumbnail image-preview" style="width: 100px;">
                                    @endif
                                </div>

                                <input type="hidden" name="type" value="0">
                                <div class="login-box-footer">
                                    <button type="submit"  class="btn btn-block btn-lg btn-primary">@lang('live.edit_profile')</button>
                                    <div class="text-hr"><span>@lang('live.or')</span></div>
                                    <p><a href="{{route('live.change-password')}}" class="link-register">@lang('live.chang_pass')</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div>
                        <div class="login-box">
                            @include('partials._errors')
                            <form action="{{route('live.edit-commercial-profile')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="number"  required="required" name="commercial_record"  placeholder="@lang('live.commercial')" value="{{ $member->commercial_record }}" id="input-commercial_record" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="date"  required="required" name="date_of_birth" title="@lang('live.input-date')"  value="{{ $member->date_of_birth }}" placeholder="تاريخ الميلاد" id="input-date" class="form-control" value="{{ old('date_of_birth') }}">
                                </div>
                                <div class="form-group">
                                    <input type="number"  required="required" name="id_number"  placeholder="@lang('live.id_number')" value="{{ $member->id_number }}" id="input-identity_number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email"  placeholder="@lang('live.email')" value="{{ $member->email }}" id="input-email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="img" class="form-control image" >
                                </div>

                                <div class="form-group">
                                    @if ($member->img)
                                        <img src="{{ asset('uploads/members/'.$member->img) }}"
                                        class="img-thumbnail image-preview" style="width: 100px;">
                                    @else

                                        <img src="{{ asset('uploads/members/default.png') }}"
                                            class="img-thumbnail image-preview" style="width: 100px;">
                                    @endif
                                </div>
                                <div class="login-box-footer">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">@lang('live.edit_profile')</button>
                                    <div class="text-hr"><span>@lang('live.or')</span></div>
                                    <p><a href="{{route('live.change-password')}}" class="link-register"> @lang('live.chang_pass')</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif


			</div>


			</div>
		</div>

 @endsection
