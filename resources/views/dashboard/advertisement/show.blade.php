@extends('layouts.dashboard.app')

@section('content')
@section('title')
    الاسئله الشائعه
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>  الاسئله الشائعه </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i> الاسئله الشائعه</li>

            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">العربيه</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">السؤال بالعربيه</label>
                                <div class="col-md-10">
                                    <input style="direction: rtl" type="text" class="form-control" value=" {{ $question->question_ar }} ؟  " readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">الاجابه بالعربيه</label>
                                <div class="col-md-10">
                                    <textarea rows="5" cols="5" class="form-control" placeholder="Enter text here" readonly="readonly">{!! $question->answer_ar !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">الانجليزيه</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">السؤال الانجليزيه</label>
                                <div class="col-md-10">
                                    <input style="direction: rtl" type="text" class="form-control" value=" {{ $question->question_en }} ؟  " readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">الاجابه الانجليزيه</label>
                                <div class="col-md-10">
                                    <textarea rows="5" cols="5" class="form-control" placeholder="Enter text here" readonly="readonly">{!! $question->answer_en !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
