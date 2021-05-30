@extends('layouts.dashboard.app')

@section('content')
@section('title')
   الاعلانات
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>  الاعلانات </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i> الاعلانات</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;"> الاعلانات
                        <small>{{ $ads->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.advertisement.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                @if(auth()->user()->hasPermission('create_users'))
                                    <a href="{{ route('dashboard.advertisement.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>اضافه</a>
                                @else
                                    <a class="btn btn-info" href="#" disabled>اضافه</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($ads->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>لاعلان</th>
                                <th>صوره الاعلان</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($ads as $index => $ad)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $ad->link }}</td>
                                    <td><img src="{{ asset('uploads/advertisement/' . $ad->img)}}" class="img-thumbnail" style="width: 50px;">

                                    <td>
                                        @if(auth()->user()->hasPermission('update_users'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.advertisement.edit' , $ad->id)}}"><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_users'))
                                            <form method="post"
                                                  action="{{route('dashboard.advertisement.destroy' , $ad->id)}}"
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
                        {{ $ads->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد اسئله</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
