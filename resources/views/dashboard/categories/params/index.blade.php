@extends('layouts.dashboard.app')

@section('content')
@section('title')
    الخصائص
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> خصائص القسم </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><a href="{{route('dashboard.cats.index')}}"></i>الاقسام</li></a>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 10px;">{{ $category->category_name_ar }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('dashboard.categories.params.create' ,  ['params' => $category])

                        </div>
                        <div class="col-md-6">
                            @include('dashboard.categories.params.show' , ['params' => $category->params()->paginate(3)])
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
