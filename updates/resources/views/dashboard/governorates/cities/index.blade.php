@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المدن
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.cities')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><a href="{{route('dashboard.governorates.index')}}"></i> @lang('site.cities')</li></a>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 10px;">{{ $governorate->governorate_name_ar }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('dashboard.governorates.cities.create' ,  ['governorate' => $governorate])
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.governorates.cities.show' , ['cities' => $governorate->cities()->paginate(3)])
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
