<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                @if (auth()->user()->image)
                    <img src="{{ asset('uploads/user_images/' . auth()->user()->image)}}" class="img-circle" alt="User Image">
                @else
                    <img src="{{ asset('uploads/user_images/default.png')}}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>
                    {{ auth()->user()->name}}
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            @if(auth()->user()->hasPermission('read_main'))
                <li class="nav-item {{is_active('index')}}">
                    <a href="{{ route('dashboard.index') }}"><i class="fa fa-th"></i><span>الرئيسيه</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_users'))
                <li class="nav-item {{is_active('users')}}">
                    <a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>المشرفين</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_governorates'))
                <li class="nav-item {{is_active('governorates')}}">
                    <a href="{{route('dashboard.governorates.index')}}"><i class="fa fa-flag"></i><span>المحافظات</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_categories'))
                <li class="nav-item {{is_active('cats')}}">
                    <a href="{{route('dashboard.cats.index')}}"><i class="fa fa-list-alt"></i><span>الاقسام</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_members'))
                <li class="treeview {{is_active('members')}}">
                    <a href="#"><i class="fa fa-address-book"></i> <span>العملاء</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="nav-item {{is_active('members')}}">
                            <a href="{{route('dashboard.members.index')}}">عميل تجاري</a>
                        </li>

                        <li class="nav-item {{is_active('members-regular')}}">
                            <a href="{{route('dashboard.members-regular-index')}}"> عميل عادي</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_auction_types'))
                <li class="nav-item {{is_active('auction-type')}}">
                    <a href="{{route('dashboard.auction-type.index')}}"><i class="fa fa-file-archive-o"></i><span>انواع المزادات</span></a>
                </li>
            @endif

            <li class="nav-item {{is_active('auction')}}">
                <a href="{{route('dashboard.get-days-of')}}"><i class="fa fa-calendar-check-o"></i><span>ايام العطله</span></a>
            </li>

            @if(auth()->user()->hasPermission('read_auctions'))
                <li class="nav-item {{is_active('auction')}}">
                    <a href="{{route('dashboard.auction.index')}}"><i class="fa fa-handshake-o"></i><span>المزادات</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_common_questions'))
                <li class="nav-item {{is_active('questions')}}">
                    <a href="{{route('dashboard.questions.index')}}"><i class="fa fa-podcast"></i><span>الاسئله الشائعه</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_advertisements'))
                <li class="nav-item {{is_active('advertisement')}}">
                    <a href="{{route('dashboard.advertisement.index')}}"><i class="fa fa-adn"></i><span> الاعلانات</span></a>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_sliders'))
                <li class="nav-item {{is_active('sliders')}}">
                    <a href="{{route('dashboard.sliders.index')}}"><i class="fa fa-sliders"></i><span> سلايدر</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_setting'))
                <li class="treeview {{is_active('setting')}}">
                    <a href="#"><i class="fa  fa-bars"></i> <span>الاعدادات</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(auth()->user()->hasPermission('read_abouts'))
                            <li><a href="{{route('dashboard.setting-about')}}"> من نحن   </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_contacts'))
                            <li><a href="{{route('dashboard.setting-contact')}}">  الرسائل   </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_privicies'))
                            <li><a href="{{route('dashboard.setting-privicies')}}">  الخصوصيه   </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_terms'))
                            <li><a href="{{route('dashboard.setting-trems')}}">  الشروط و الاحكام   </a></li>
                        @endif
                        <li><a href="{{route('dashboard.setting-get-phone')}}">  ارقام الشركه   </a></li>
                    </ul>
                </li>
            @endif
        </ul>

    </section>

</aside>
