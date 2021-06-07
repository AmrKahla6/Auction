@extends('layouts.online.member')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>@lang('live.about_as')</h3>
            <p>@lang('live.about_header')</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-content">
                <h3> @lang('live.about_as')</h3>
                    {!! $about->detials !!}
                <h3>@lang('live.vision')</h3>
                {!! $privcy->privcy !!}
            </div>
        </div>
    </div>
</div>
@endsection
