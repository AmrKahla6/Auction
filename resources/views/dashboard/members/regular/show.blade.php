@extends('layouts.dashboard.app')

@section('content')
@section('title')
   عميل
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1> {{$member->username}} </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i>العملاء</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-body">
                    <div class="col-md-8">
                        <div class="form-group col-md-6">
                            <label>البريد الالكتروني</label>
                            <span  class="form-control">{{$member->email}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>رقم الهاتف</label>
                            <span class="form-control">{{$member->phone}}</span>
                        </div>
                    </div>

                    <div class="col-md-8">

                        <div class="form-group col-md-6">
                            <label>  تاريخ الميلاد </label>
                            <span  class="form-control">{{$member->date_of_birth}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>  الجنسيه  </label>
                            <span  class="form-control">{{$member->country->country_name_ar}}</span>
                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group col-md-6">
                            <label>صوره </label><br>
                            <img src="{{asset('uploads/members/'.$member->img)}}" width="200" height="200" alt="" srcset="">
                        </div>
                    </div>


                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
