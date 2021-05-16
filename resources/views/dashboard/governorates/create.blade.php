@extends('layouts.dashboard.app')

@section('content')
@section('title')
    اضافه محافظه
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>المحافظات</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.governorates.index')}}">المحافظات</a></li>
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
                    <form action="{{ route('dashboard.governorates.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>الاسم بالعربيه</label>
                            <input type="text" name="governorate_name_ar" class="form-control" value="{{ old('governorate_name_ar') }}" >
                        </div>
                        <div class="form-group">
                            <label>الاسم بالانجليزيه</label>
                            <input type="text" name="governorate_name_en" class="form-control" value="{{ old('governorate_name_en') }}" >
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
