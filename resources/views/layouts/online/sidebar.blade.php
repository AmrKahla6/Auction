<div class="sub-nav">
    <div class="sub-nav-content">
        <div class="content-menu">
            <ul>
                @if(!empty(App\Models\Member::find(auth()->guard('members')->id())))
                    <li><a href="{{route("live.profile")}}"><span class="icon-user1"></span> @lang('live.my_acc')</a></li>
                    <li><a href="{{route("live.myonline")}}"><span class="icon-settings"></span> @lang('live.main')</a></li>
                    <li><a href="#"><span class="icon-settings"></span> @lang('live.setting')</a></li>
                    <li><a href="{{route('live.add_auctions')}}"><span class="icon-plus-circle"></span> @lang('live.add_auction')</a></li>
                    <li><a href="{{route('live.registerd')}}"><span class="icon-plus-circle"></span> @lang('live.my_auctions')</a></li>
                    <li><a href="{{route('live.my_favorite',auth()->guard('members')->id())}}"><span class="icon-heart1"></span> @lang('live.my_fav') </a></li>
                    <li><a href="{{route('live.contact-us')}}"><span class="icon-message-circle"></span> @lang('live.my_msg') <span class="num">0</span></a></li>
                    <li><a href="{{route('live.aboute')}}"><span class="icon-info"></span> @lang('live.about_as')</a></li>
                    <li><a href="{{route('live.common-questions')}}"><span class="icon-help-circle"></span> @lang('live.comm_question')</a></li>
                    <li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span> @lang('live.terms')</a></li>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li><a rel="alternate"  hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <span class="icon-earth"></span> {{ $properties['native'] }}</a>
                        </li>
                    @endforeach
                    <li class="btn-logout"><a href="{{route('live.logout')}}"><span class="icon-power"></span> @lang('live.logout')</a></li>
                @else
                    <li><a href="{{route('live.login')}}"><span class="icon-user1"></span> @lang('live.l-login')</a></li>
                    <li><a href="{{route('live.register')}}"><span class="icon-user-plus1"></span> @lang('live.register')</a></li>
                    <li><a href="{{route('live.aboute')}}"><span class="icon-info"></span>@lang('live.about_as')</a></li>
                    <li><a href="{{route('live.common-questions')}}"><span class="icon-help-circle"></span>@lang('live.comm_question')</a></li>
                    <li><a href="{{route('live.terms')}}"><span class="icon-alert-triangle"></span>  @lang('live.terms')</a></li>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li><a rel="alternate"  hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <span class="icon-earth"></span> {{ $properties['native'] }}</a>
                        </li>
                    @endforeach
                @endif


            </ul>
        </div>
    </div>
</div>
