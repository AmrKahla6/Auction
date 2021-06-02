@extends('layouts.dashboard.app')

@section('content')
@section('title')
    اضافه نوع
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>انواع المزادات</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.auction-type.index')}}">انواع المزادات</a></li>
                <li class="active"></i> @lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.auction-type.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>نوع المزاد بالعربيه</label>
                            <input type="text" name="type_name_ar" placeholder="اضف نوع المزاد بالعربيه" class="form-control" value="{{ old('type_name_ar') }}" >
                        </div>


                        <div class="form-group">
                            <label>نوع المزاد بالانجليزيه</label>
                            <input type="text" name="type_name_en" placeholder="اضف نوع المزاد بالانجليزيه" class="form-control" value="{{ old('type_name_en') }}" >
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
