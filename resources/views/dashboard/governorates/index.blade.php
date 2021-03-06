@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المحافظات
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>المحافظات
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i>المحافظات</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">المحافظات
                        <small>{{ $govtes->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.governorates.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_governorates'))
                                    <a href="{{ route('dashboard.governorates.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <a class="btn btn-primary" href="#" disabled><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($govtes->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>الاسم بالعربيه</th>
                                <th>الاسم بالانجليزيه</th>
                                <th>@lang('site.districts')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($govtes as $index => $govte)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $govte->governorate_name_ar }}</td>
                                    <td>{{ $govte->governorate_name_en }}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('read_cities'))
                                            <a href="{{ route('dashboard.governorates.cities.index' ,  $govte->id) }}" class="btn btn-warning btn-sm">@lang('site.related_districts')</a>
                                        @else
                                        <a href="#" class="btn btn-warning btn-sm" disabled>@lang('site.related_districts')</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_governorates'))
                                            <a class="btn btn-info btn-sm" title="تعديل المحافظه !"
                                                href="{{route('dashboard.governorates.edit' , $govte->id)}}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @endif


                                        @if(auth()->user()->hasPermission('delete_governorates'))
                                            <form method="post"
                                                    action="{{route('dashboard.governorates.destroy' , $govte->id)}}"
                                                    style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" title="حذف المحافظه !" class="btn btn-danger btn-sm delete"><i
                                                        class="fa fa-trash"></i>@lang('site.delete')</button>
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
                        {{ $govtes->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
