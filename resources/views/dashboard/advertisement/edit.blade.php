@extends('layouts.dashboard.app')

@section('content')
@section('title')
    تعديل الاعلان
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>تعديل الاعلان
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.advertisement.index')}}">الاعلانات</a></li>
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
                    <form action="{{ route('dashboard.advertisement.update' , $ads->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <input type="hidden" name="id" value="{{$ads->id}}">
                            <div class="form-group">
                                <label>الاعلان</label>
                                <input type="text" name="link" class="form-control" value="{{ $ads->link}}" >
                            </div>

                            <div class="form-group">
                                <label>الصوره</label>
                                <input type="file" name="img" class="form-control image" >
                            </div>

                            <div class="form-group">
                                <img src="{{ asset('uploads/advertisement/'.$ads->img) }}"
                                     class="img-thumbnail image-preview" style="width: 100px;">
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
