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

            <li class="nav-item {{is_active('index')}}">
                <a href="{{ route('dashboard.index') }}"><i class="fa fa-th"></i><span>الرئيسيه</span></a>
            </li>

            @if(auth()->user()->hasPermission('read_users'))
                <li class="nav-item {{is_active('users')}}">
                    <a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>المشروفين</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_governorates'))
                <li class="nav-item {{is_active('governorates')}}">
                    <a href="{{route('dashboard.governorates.index')}}"><i class="fa fa-flag"></i><span>المحافظات</span></a>
                </li>
            @endif

            <li class="nav-item {{is_active('cats')}}">
                <a href="{{route('dashboard.cats.index')}}"><i class="fa fa-flag"></i><span>الاقسام</span></a>
            </li>

                <li class="treeview {{is_active('members')}}">
                    <a href="#"><i class="fa fa-car"></i> <span>العملاء</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="nav-item {{is_active('full-insurance')}}">
                            <a href="{{route('dashboard.members.index')}}">عميل تجاري</a>
                        </li>

                        <li class="nav-item {{is_active('full-insurance')}}">
                            <a href="{{route('dashboard.members-regular-index')}}"> عميل عادي</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{is_active('auction')}}">
                    <a href="{{route('dashboard.auction.index')}}"><i class="fa fa-flag"></i><span>المزادات</span></a>
                </li>
        </ul>

    </section>

</aside>
