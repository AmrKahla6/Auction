@extends('layouts.dashboard.app')

@section('content')
@section('title')
   الشروط و الاحكام
@endsection
    <div class="content-wrapper">

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">الشروط و الاحكام</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.setting-privicies-edit',$privicies->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>الشروط بالعربيه</label>
                            <textarea name="privcy_ar" id=""  class="form-control ckeditor" cols="30" rows="10">{!! $privicies->privcy_ar !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>الشروط بالانجليزيه</label>
                            <textarea name="privcy_en" id="" class="form-control ckeditor" cols="30" rows="10">{!! $privicies->privcy_en !!}</textarea>
                        </div>
                        <div class="form-group">
                            @if(auth()->user()->hasPermission('update_terms'))
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')</button>
                            @else
                                <button class="btn btn-primary" disabled><i class="fa fa-plus"></i>@lang('site.edit')</button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
