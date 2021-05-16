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
                    <a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>المشروفين</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_governorates'))
                <li class="nav-item {{is_active('governorates')}}">
                    <a href="{{route('dashboard.governorates.index')}}"><i class="fa fa-flag"></i><span>المحافظات</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_services'))
                <li class="nav-item {{is_active('services')}}">
                    <a href="{{route('dashboard.services.index')}}"><i class="fa fa-shopping-cart"></i><span>الخدمات</span></a>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_companies'))
                <li class="nav-item {{is_active('companies')}}">
                    <a href="{{route('dashboard.companies.index')}}"><i class="fa fa-building"></i><span>الشركات</span></a>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_members'))
                <li class="nav-item {{is_active('members')}}">
                    <a href="{{route('dashboard.member-index')}}"><i class="fa fa-child"></i><span>العملاء</span></a>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_car-insurance'))
                <li class="treeview {{is_active('cars')}}">
                    <a href="#"><i class="fa fa-car"></i> <span>تامين سيارات</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">

                        @if(auth()->user()->hasPermission('read_car_full_insurances'))
                            <li class="nav-item {{is_active('full-insurance')}}">
                                <a href="{{route('dashboard.full-insurance')}}">تامين شامل</a>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('read_car_insurance_againsts'))
                            <li><a href="{{route('dashboard.aginst-insurance')}}">تامين ضد الغير</a></li>
                    @endif

                    @if(auth()->user()->hasPermission('read_car_full_insurance_models'))
                            <li><a href="{{route('dashboard.get-model')}}"> موديل السياره </a></li>
                    @endif

                    @if(auth()->user()->hasPermission('read_insurance_full_model_types'))
                        <li><a href="{{route('dashboard.get-model-type')}}">انواع موديل السيارات  </a></li>
                    @endif


                    @if(auth()->user()->hasPermission('read_car_insurance_against_types'))
                            <li><a href="{{route('dashboard.get-type')}}"> نوع السياره </a></li>
                    @endif

                    @if(auth()->user()->hasPermission('read_car_insurance_against_seats'))
                            <li><a href="{{route('dashboard.get-seats')}}">  عدد المقاعد </a></li>
                    @endif

                    </ul>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_travel-insurance'))
                <li class="treeview {{is_active('travel')}}">
                    <a href="#"><i class="fa fa-plane"></i> <span>تامين السفر</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(auth()->user()->hasPermission('read_family_travel_insurances'))
                            <li><a href="{{route('dashboard.family-insurance')}}"> تامين عائلي </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_individual_travel_insurances'))
                            <li><a href="{{route('dashboard.individual-insurance')}}"> تامين فردي </a></li>
                        @endif


                        @if(auth()->user()->hasPermission('read_packages'))
                            <li><a href="{{route('dashboard.get-package')}}">الباقات</a></li>
                        @endif

                    </ul>
                </li>
            @endif


            @if(auth()->user()->hasPermission('read_boat-insurance'))
                <li class="treeview {{is_active('boat')}}">
                    <a href="#"><i class="fa fa-ship"></i> <span>تامين قوارب</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(auth()->user()->hasPermission('read_boat_insurances'))
                            <li><a href="{{route('dashboard.boat-insurance')}}"> تامين سفينه </a></li>
                        @endif


                        @if(auth()->user()->hasPermission('read_get_boat_insurances'))
                            <li><a href="{{route('dashboard.seky-insurance')}}"> تامين سكي </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_liability_limits'))
                            <li><a href="{{route('dashboard.get-liability-limits')}}">  حدود المسؤوليه </a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_setting'))
                <li class="treeview {{is_active('setting')}}">
                    <a href="#"><i class="fa  fa-bars"></i> <span>الاعدادات</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(auth()->user()->hasPermission('read_abouts'))
                            <li><a href="{{route('dashboard.setting-about')}}"> من نحن   </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_company_information'))
                            <li><a href="{{route('dashboard.setting-company')}}"> الشركه </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_contact__us'))
                            <li><a href="{{route('dashboard.setting-contact')}}"> تواصل معانا </a></li>
                        @endif

                        @if(auth()->user()->hasPermission('read_terms'))
                            <li><a href="{{route('dashboard.setting-trems')}}">  الشروط و الاحكام </a></li>
                        @endif

                    </ul>
                </li>
            @endif

        </ul>

    </section>

</aside>
