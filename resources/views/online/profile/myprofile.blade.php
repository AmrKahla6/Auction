@extends('layouts.online.member')
@section('content')
<div class="container">
    <div id="profile-page">
        @include('partials._errors')
        @include('partials._session')
        <div class="profile-head">
            <a class="link-setting" href="{{route('live.edit-profile')}}"><span class="icon-settings"></span></a>
            <div class="about">
                <div class="image">
                    @if ($member->img)
                        <img src="{{ asset('uploads/user_images/'.$member->img)}}" class="img-responsive" />
                    @endif
                </div>
                <div class="content">
                    <div class="username">{{$member->username}}</div>
                    <div class="mail">{{$member->email}}</div>
                </div>
            </div>
            <div class="numbers">
                <div>
                    <b>{{$member->tenders()->count()}}</b>
                    <p>@lang('live.tenders')</p>
                </div>
                <div>
                    <b>{{$member->auctions()->where('is_finished',0)->count()}}</b>
                    <p>@lang('live.curr_auction')</p>
                </div>
                <div>
                    <b>{{$member->auctions()->where('is_finished',1)->count()}}</b>
                    <p>@lang('live.finish_auction')</p>
                </div>
            </div>
            <div class="balance">
                <div class="content">
                    <p>@lang('live.wallet')</p>
                    <b>{{isset($member->balance) ? $member->balance : 0}}</b>
                </div>
                <button type="button" class="btn btn-balance" data-id="{{ $member->id }}" data-balance="{{ $member->balance }}" data-toggle="modal" data-target="#buy_credit_modal">
                    @lang('live.buy')
                </button>
            </div>
        </div>
        <div class="profile-links">
            <a href="{{route('live.my_tenders')}}"><span class="icon-activity"></span> @lang('live.my_tenders')</a>
            <a href="{{route('live.registerd')}}"><span class="icon-share"></span> @lang('live.my_auctions')</a>
            <a href="{{route('live.my_favorite',Auth::guard('members')->user())}}"><span class="icon-heart1"></span> @lang('live.my_fav')</a>
            <a href="#"><span class="icon-bell1"></span> @lang('live.notification') <span class="num">0</span></a>
            <a href="{{route('live.contact-us')}}"><span class="icon-headphones"></span> @lang('live.call')</a>
            <a href="{{route('live.aboute')}}"><span class="icon-info"></span> @lang('live.about_as')</a>
            <a href="{{route('live.common-questions')}}"><span class="icon-help-circle"></span> @lang('live.comm_question')</a>
            <a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span> @lang('live.terms')</a>
            <a class="btn-logout" href="{{route('live.logout')}}"><span class="icon-power"></span> @lang('live.logout') </a>
        </div>
    </div>

    <div class="modal fade" id="buy_credit_modal" tabindex="-1" role="dialog" aria-labelledby="buy_credit_modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buy_credit_modalTitle">@lang('live.wallet')
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="icon-x"></span>
                        </button>
                    </h5>
                </div>
                <div class="modal-body">
                    <h3><span class="icon-wallet"></span> رصيد محفظتي</h3>
                    <div class="mycredit">
                        <p>رصيدي المتاح</p>
                        <b>{{isset($member->balance) ? $member->balance : 0}}</b>
                    </div>
                        <h3>شحن محفظتي</h3>
                        <form action="profile/update-balance" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="id" value="{{$member->id}}">
                            <input type="text" name="balance" value="" placeholder="اكتب قيمة الشحن" id="add_credit" class="form-control">
                            <button type="submit" class="btn btn-primary">شحن</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //Edit Catgeoy
    $('#buy_credit_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var balance = button.data('balance')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #add_credit').val(balance);
    })
</script>
@endsection
