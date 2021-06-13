@extends('layouts.online.member')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>@lang('live.terms_uses')</h3>
            <p>@lang('live.read_terms')</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-content">
                <div style="text-align: justify;padding:10px;" dir="rtl">
                    {{$term->term}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
