@extends('layouts.dashboard.app')

@section('content')
@section('title')
    تعديل السؤال
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>تعديل السؤال
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.questions.index')}}">الاسئله الشائعه</a></li>
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
                    <form action="{{ route('dashboard.questions.update' , $question->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('put')
                            <input type="hidden" name="id" value="{{$question->id}}">
                            <div class="form-group">
                                <label>السؤال بالعربيه</label>
                                <input type="text" name="question_ar" class="form-control" value="{{ $question->question_ar}}" >
                            </div>

                            <div class="form-group">
                                <label>الاجابه بالعربيه</label>
                                <textarea name="answer_ar" id="" class="form-control ckeditor" cols="30" rows="10">{!! $question->answer_ar !!}</textarea>
                            </div>


                            <div class="form-group">
                                <label>السؤال بالانجليزيه</label>
                                <input type="text" name="question_en" class="form-control" value="{{ $question->question_en }}" >
                            </div>

                            <div class="form-group">
                                <label>الاجابه بالانجليزيه</label>
                                <textarea name="answer_en" id="" class="form-control ckeditor" cols="30" rows="10">{!! $question->answer_en !!}</textarea>
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
