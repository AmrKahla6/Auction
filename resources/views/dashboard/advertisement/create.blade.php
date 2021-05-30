@extends('layouts.dashboard.app')

@section('content')
@section('title')
    اضافه اعلان
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1> الاعلانات</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.questions.index')}}">الاعلانات</a></li>
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
                    <form action="{{ route('dashboard.advertisement.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label> الاعلان</label>
                            <input type="text" name="link" placeholder="رابط الاعلان" class="form-control" value="{{ old('link') }}" >
                        </div>

                        <div class="form-group">
                            <label>صوره الاعلان</label>
                            <input type="file" name="img" class="form-control image" >
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/advertisement/default.png') }}"
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
