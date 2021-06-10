@extends('layouts.online.member')
@section('content')

<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>@lang('live.contact_us')</h3>
            <p>@lang('live.happy_contact')</p>
        </div>
    </div>
</div>

<div class="contactus-page">
    @include('partials._errors')
    @include('partials._session')
    <form action="{{route('live.store-contact-us')}}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <label for="message">@lang('live.write_note')</label>
        <textarea type="text" id="message" name="message" rows="5" placeholder="@lang('live.write_here')" class="form-control md-textarea">{{ old('message') }}</textarea>
        <button type="submit" class="btn btn-block btn-lg btn-primary">@lang('live.send_contact')</button>
    </form>
    <h3>@lang('live.contact_with')</h3>
    <div class="phone-numbers">
        <ul>
            <li>
                <h3><span class="icon-phone"></span> 0123456789 <a href="tel:0123456789"><span class="icon-phone"></span></a></h3>
            </li>
            <li>
                <h3><span class="icon-phone"></span> 0123456789 <a href="tel:0123456789"><span class="icon-phone"></span></a></h3>
            </li>
            <li>
                <h3><span class="icon-phone"></span> 0123456789 <a href="tel:0123456789"><span class="icon-phone"></span></a></h3>
            </li>
        </ul>
    </div>
</div>
@endsection
