@extends('layouts.dashboard.app')

@section('content')
@section('title')
    تعديل نوع المزاد
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1> تعديل نوع المزاد
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.questions.index')}}">  انواع المزادات</a></li>
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
                    <form action="{{ route('dashboard.auction-type.update' , $type->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('put')
                            <input type="hidden" name="id" value="{{$type->id}}">
                            <div class="form-group">
                                <label>السؤال بالعربيه</label>
                                <input type="text" name="type_name_ar" class="form-control" value="{{ $type->type_name_ar}}" >
                            </div>


                            <div class="form-group">
                                <label>السؤال بالانجليزيه</label>
                                <input type="text" name="type_name_en" class="form-control" value="{{ $type->type_name_en }}" >
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
