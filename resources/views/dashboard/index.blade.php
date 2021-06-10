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
                            <p>حساب تجاري</p>
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
                            <p>حساب عادي</p>
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
                        <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$current_auction_count}}</h3>
                            <p>المزادات الحاليه</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('dashboard.auction.index')}}" class="small-box-footer"> المزادات <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div><!-- ./col -->
                @endif


                @if(auth()->user()->hasPermission('read_auctions'))
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$finish_auction_count}}</h3>
                        <p>المزادات المنتهيه</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('dashboard.auction.index')}}" class="small-box-footer"> المزادات <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div><!-- ./col -->
            @endif
            </div>


            <h2>اخر المزادات</h2>
            <div class="box-body">
            @if($auctions->count() > 0)
            <table class="table table-hover" style="background-color: white">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th scope="col"> العضو</th>
                    <th scope="col">عنوان المزاد</th>
                    <th scope="col"> التفعيل</th>
                    <th scope="col">عمليات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($auctions as $index => $acution)
                    <tr>
                        <th scope="col"> {{ $index +1 }}</th>
                        <td scope="col">{{ isset($acution->member->username ) ? $acution->member->username : $acution->member->email}}</td>
                        <td scope="col">{{ $acution->auction_title }}</td>
                        <td scope="col">
                            @if ($acution->status == 0)
                                <span class="badge badge-light">مفعل</span>
                            @else
                                 غير مفعل
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->hasPermission('read_tenders'))
                                <a class="btn btn-info btn-sm"
                                    href="{{route('dashboard.auction.tenders-index' , $acution->id)}}">
                                    <i class="fa fa-terminal"></i>
                                            المزايدات
                                </a>
                            @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i
                                        class="fa fa-edit"></i>تعديل</a>
                            @endif




                        @if(auth()->user()->hasPermission('read_auctions'))
                            <a class="btn btn-info btn-sm"
                                href="{{route('dashboard.auction.show' , $acution->id)}}"><i
                                        class="fa fa-book"></i>عرض</a>
                        @else
                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                    class="fa fa-book"></i>عرض</a>
                        @endif

                        @if(auth()->user()->hasPermission('update_acution_cancle'))
                                <form method="post"
                                        action="{{route('dashboard.auction.disabled' , $acution->id)}}"
                                        style="display: inline-block">
                                      @csrf()
                                      @if ($acution->status == 0)

                                        <button type="submit" class="btn btn-primary btn-sm"><i
                                                  class="fa fa-trash-o"></i>الغاء</button>
                                      @else
                                        <button type="submit" class="btn btn-blue btn-sm"><i
                                            class="fa fa-trash-o"></i>تفعيل</button>
                                      @endif
                                </form>
                        @else
                            @if ($acution->status == 0)
                                <a class="btn btn-info btn-sm" href="#" disabled><i
                                    class="fa fa-book"></i>الغاء</a>
                            @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i
                                    class="fa fa-book"></i>تفعيل</a>
                            @endif
                        @endif

                            <form method="post"
                                action="{{route('dashboard.auction.destroy' , $acution->id)}}"
                                style="display: inline-block">
                                @csrf()
                                @method('delete')
                                    @if(auth()->user()->hasPermission('delete_auctions'))
                                            <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                        class="fa fa-trash"></i>حذف</button>
                                    @else
                                        <a class="btn btn-danger btn-sm" href="#" disabled><i
                                                class="fa fa-trash"></i>حذف</a>
                                    @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
                @else
                    <h2>لا يوجد مزادات حاليه</h2>
                @endif
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

@push('scripts')

@endpush
