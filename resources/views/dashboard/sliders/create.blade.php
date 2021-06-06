@extends('layouts.dashboard.app')

@section('content')
@section('title')
    اضف سلايدر
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>سلايدر</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.sliders.index')}}">سلايدر</a></li>
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
                    <form action="{{ route('dashboard.sliders.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>العنوان بالعربيه</label>
                            <input type="text" name="title_ar" placeholder="اضف نص السؤال بالعربيه" class="form-control" value="{{ old('title_ar') }}" >
                        </div>

                        <div class="form-group">
                            <label>التفاصيل بالعربيه</label>
                            <textarea name="body_ar" id="" class="form-control ckeditor" cols="30" rows="10">{!! old('body_ar') !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>العنوان بالانجليزيه</label>
                            <input type="text" name="title_en" placeholder="اضف نص السؤال بالانجليزيه" class="form-control" value="{{ old('title_en') }}" >
                        </div>

                        <div class="form-group">
                            <label>التفاصيل بالانجليزيه</label>
                            <textarea name="body_en" id="" class="form-control ckeditor" cols="30" rows="10">{!! old('body_en') !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>الصوره</label>
                            <input type="file" name="img" class="form-control image" >
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/slider/default.png') }}"
                                 class="img-thumbnail image-preview" style="width: 100px;">
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
