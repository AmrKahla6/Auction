@extends('layouts.dashboard.app')

@section('content')
@section('title')
    اضافه قسم
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>اضافه قسم جديد</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.cats.index')}}">المحافظات</a></li>
                <li class="active"></i> @lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.cats.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>الاسم بالعربيه</label>
                            <input type="text" name="category_name_ar" placeholder="اسم القسم بالعربيه" class="form-control" value="{{ old('category_name_ar') }}" >
                        </div>

                        <div class="form-group">
                            <label>الاسم بالانجليزيه</label>
                            <input type="text" name="category_name_en" placeholder="اسم القسم بالانجليزيه" class="form-control" value="{{ old('category_name_en') }}" >
                        </div>

                        <div class="form-group">
                            <label>القسم</label>
                            <select name="parent_id" id="" class="form-control">
                                <option value="" selected>اختر القسم (قسم اساسي)</option>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->id}}">{{$cat->category_name_ar}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>الصوره</label>
                            <input type="file" name="img" class="form-control image" >
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/category/default.png') }}"
                                 class="img-thumbnail image-preview" style="width: 100px;">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
