@extends('layouts.dashboard.app')

@section('content')
@section('title')
    العملاء
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> العملاء </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i>العملاء</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">العملاء
                        <small>{{ $members->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.members-regular-index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-search"></i>@lang('site.search')</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($members->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th> الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الصوره</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($members as $index => $user)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                        <td><img src="{{ asset('uploads/members/' . $user->img)}}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>

                                        @if(auth()->user()->hasPermission('read_favorites'))
                                            <a class="btn btn-primary btn-sm"
                                                href="{{route('dashboard.members-get-favorite' , $user->id)}}"><i
                                                    class="fa fa-heart"></i>المفضله</a>
                                        @else
                                            <a class="btn btn-primary btn-sm" href="#" disabled><i
                                                class="fa fa-heart"></i>المفضله</a>
                                        @endif

                                        @if(auth()->user()->hasPermission('read_regular_member'))
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('dashboard.members-regular-show' , $user->id)}}"><i
                                                        class="fa fa-edit"></i>عرض</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                class="fa fa-edit"></i>عرض</a>
                                        @endif

                                            <form method="post"
                                                  action="{{route('dashboard.members-regular-destroy' , $user->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                @if(auth()->user()->hasPermission('delete_regular_member'))
                                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                                class="fa fa-trash"></i>حذف</button>
                                                @else
                                                    <a class="btn btn-danger btn-sm" href="#" disabled><i
                                                        class="fa fa-trash"></i>حذف</a>
                                                @endif
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $members->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد عملاء</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
