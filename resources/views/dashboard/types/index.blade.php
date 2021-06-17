@extends('layouts.dashboard.app')

@section('content')
@section('title')
    انواع المزادات
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> انواع المزادات </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i>انواع المزادات</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">انواع المزادات
                        <small>{{ $types->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.auction-type.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                @if(auth()->user()->hasPermission('create_auction_types'))
                                    <a href="{{ route('dashboard.auction-type.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>اضافه</a>
                                @else
                                    <a class="btn btn-plus" href="#" disabled>اضافه</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($types->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>نوع المزاد بالعربيه</th>
                                <th>نواع المزاد بالانجليزيه</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($types as $index => $type)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $type->type_name_ar }}</td>
                                    <td>{{ $type->type_name_en }}</td>
                                    @if ($type->id != 1)
                                        <td>
                                            @if(auth()->user()->hasPermission('update_auction_types'))
                                                <a class="btn btn-info btn-sm"
                                                href="{{route('dashboard.auction-type.edit' , $type->id)}}"><i
                                                            class="fa fa-edit"></i>تعديل</a>
                                            @else
                                                <a class="btn btn-info btn-sm" href="#" disabled><i
                                                            class="fa fa-edit"></i>تعديل</a>
                                            @endif
                                            @if(auth()->user()->hasPermission('delete_auction_types'))
                                                <form method="post"
                                                    action="{{route('dashboard.auction-type.destroy' , $type->id)}}"
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
                                    @else
                                        <td>
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>

                                            <button type="submit" class="btn btn-danger btn-sm" disabled><i
                                                        class="fa fa-trash"></i>حذف</button>
                                        </td>
                                        @endif
                                    </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $types->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد بيانات</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
