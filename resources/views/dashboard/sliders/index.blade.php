@extends('layouts.dashboard.app')

@section('content')
@section('title')
     سلايدر
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> سلايدر</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i>سلايدر</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;"> سلايدر
                        <small>{{ $sliders->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.sliders.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                @if(auth()->user()->hasPermission('create_sliders'))
                                    <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>اضافه</a>
                                @else
                                    <a class="btn btn-plus" href="#" disabled>اضافه</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($sliders->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>عنوان السلايدر</th>
                                <th>صوره</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($sliders as $index => $slider)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $slider->title_ar }}</td>
                                    <td><img src="{{ asset('uploads/slider/' . $slider->img)}}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                               href="{{route('dashboard.sliders.show' , $slider->id)}}"><i
                                                        class="fa fa-show"></i>عرض</a>

                                        @if(auth()->user()->hasPermission('update_sliders'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.sliders.edit' , $slider->id)}}"><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_sliders'))
                                            <form method="post"
                                                  action="{{route('dashboard.sliders.destroy' , $slider->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fa fa-trash"></i>حذف</button>
                                            </form>
                                        @else
                                            <button type="submit" class="btn btn-danger btn-sm" disabled><i
                                                        class="fa fa-trash"></i>حذف</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $sliders->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد اسئله</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
