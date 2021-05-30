@extends('layouts.dashboard.app')

@section('content')
@section('title')
   من نحن
@endsection
    <div class="content-wrapper">

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">حول</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.setting-about-edit',$about->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>التفاصيل بالعربيه</label>
                            <textarea name="detials_ar" id=""  class="form-control ckeditor" cols="30" rows="10">{!! $about->detials_ar !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>التفاصيل بالانجليزيه</label>
                            <textarea name="detials_en" id="" class="form-control ckeditor" cols="30" rows="10">{!! $about->detials_en !!}</textarea>
                        </div>
                        <div class="form-group">
                            @if(auth()->user()->hasPermission('update_abouts'))
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                            @else
                                <button class="btn btn-primary" disabled><i class="fa fa-plus"></i>@lang('site.edit')
                            @endif
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
