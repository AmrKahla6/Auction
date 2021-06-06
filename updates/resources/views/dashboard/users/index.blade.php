@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المشرفين
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> المشرفين </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i>المشرفين</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">المشرفين
                        <small>{{ $users->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.users.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                @if(auth()->user()->hasPermission('create_users'))
                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>اضافه</a>
                                @else
                                    <a class="btn btn-info" href="#" disabled>اضافه</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($users->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الصوره</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><img src="{{ asset('uploads/user_images/' . $user->image)}}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_users'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.users.edit' , $user->id)}}"><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_users'))
                                            <form method="post"
                                                  action="{{route('dashboard.users.destroy' , $user->id)}}"
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
                        {{ $users->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد مشرفين</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
