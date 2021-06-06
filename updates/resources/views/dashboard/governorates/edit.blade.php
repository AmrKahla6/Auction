@extends('layouts.dashboard.app')

@section('content')
@section('title')
    تعديل المحافظه
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.governorates.index')}}">@lang('site.cities')</a></li>
                <li class="active"></i> @lang('site.update')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.governorates.update' , $governorate->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('put')
                            <input type="hidden" name="id" value="{{$governorate->id}}">
                            <div class="form-group">
                                <label>الاسم بالعربيه</label>
                                <input type="text" name="governorate_name_ar" class="form-control" value="{{ $governorate->governorate_name_ar}}" >
                            </div>
                            <div class="form-group">
                                <label>الاسم بالانجليزيه</label>
                                <input type="text" name="governorate_name_en" class="form-control" value="{{ $governorate->governorate_name_en }}" >
                            </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
