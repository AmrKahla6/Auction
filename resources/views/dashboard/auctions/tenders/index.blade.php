@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المزايدات
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>المزايدات
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><a href="{{route('dashboard.auction.index')}}"></i> المزايدات</li></a>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 10px;">{{ $acution->auction_title }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('dashboard.auctions.tenders.show' , ['tenders' => $acution->tenders()->paginate(3)])
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
