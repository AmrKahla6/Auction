@extends('layouts.dashboard.app')

@section('content')
@section('title')
    الرئيسيه
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>الرئيسيه</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> الرئيسيه </li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                @if(auth()->user()->hasPermission('read_users'))
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{$users_count}}</h3>
                            <p>المشرفين</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('dashboard.users.index')}}" class="small-box-footer"> المشرفين <i class="fa fa-arrow-circle-left"></i></a>
                        </div>

                    </div><!-- ./col -->
                @endif

                @if(auth()->user()->hasPermission('read_members'))
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$members_comercal_count}}</h3>
                            <p>عملاء تجارين</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('dashboard.members.index')}}" class="small-box-footer"> عملاء تجارين <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                @endif


                @if(auth()->user()->hasPermission('read_members'))
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$members_regular_count}}</h3>
                            <p>عملاء عادين</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('dashboard.members-regular-index')}}" class="small-box-footer"> عملاء عادين <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                @endif


                @if(auth()->user()->hasPermission('read_auctions'))
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$auction_count}}</h3>
                            <p>المزادات</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('dashboard.auction.index')}}" class="small-box-footer"> المزادات <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                @endif
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

@push('scripts')

@endpush
