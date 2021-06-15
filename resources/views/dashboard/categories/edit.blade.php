@extends('layouts.dashboard.app')

@section('content')
@section('title')
    تعديل القسم
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.cats.index')}}">تعديل القسم</a></li>
                <li class="active"></i> @lang('site.update')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.cats.update',$category->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <input type="hidden" name="id" value="{{$category->id}}">
                            <div class="form-group">
                                <label>الاسم بالعربيه</label>
                                <input type="text" name="category_name_ar" class="form-control" value="{{ $category->category_name_ar}}" >
                            </div>
                            <div class="form-group">
                                <label>الاسم بالانجليزيه</label>
                                <input type="text" name="category_name_en" class="form-control" value="{{ $category->category_name_en }}" >
                            </div>

                            <div class="form-group">
                                <label>القسم</label>
                                <select name="parent_id" id="" class="form-control catSelect">
                                    <option value="">اختر القسم (قسم اساسي)</option>
                                    @foreach ($cats as $cat)
                                        <option value="{{$cat->id}}" {{(old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '')}} >{{$cat->category_name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (empty($category->price))
                                <div class="form-group changePrice" style="display: none">
                                    <label>السعر</label>
                                    <input type="number" name="price" placeholder="السعر" class="form-control" value="{{ $category->price }}" >
                                </div>
                            @else
                                <div class="form-group changePrice">
                                    <label>السعر</label>
                                    <input type="number" name="price" placeholder="السعر" class="form-control" value="{{ $category->price }}" >
                                </div>
                            @endif

                            <div class="form-group">
                                <label>الصوره</label>
                                <input type="file" name="img" class="form-control image" >
                            </div>

                            <div class="form-group">
                                <img src="{{ asset('uploads/category/'.$category->img) }}"
                                     class="img-thumbnail image-preview" style="width: 100px;">
                            </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

    @section('scripts')
    <script>
        $( ".catSelect" ).change(function() {
            let catValue =  $(this).children(":selected").attr("value");
            if(catValue == 0){
                $(".changePrice").show();
            }else{
                $(".changePrice").hide();
            }
        });
    </script>
@endsection

@endsection
