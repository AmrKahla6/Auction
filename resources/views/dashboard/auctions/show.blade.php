@extends('layouts.dashboard.app')

@section('content')
@section('title')
     عرض المزاد
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>{{$acution->auction_title}}</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> المزادات </li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-body">
                    <div class="col-md-8">
                        <div class="form-group col-md-6">
                            <label> معلومات العميل</label>
                            <span  class="form-control">{{$acution->member->username}}</span>
                            <span  class="form-control">{{$acution->member->email}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label> العنوان</label>
                            <span class="form-control">{{$acution->address}}</span>
                        </div>
                    </div>

                    <div class="col-md-8">

                        <div class="form-group col-md-6">
                            <label> السعر الافتتاحي</label>
                            <span  class="form-control">{{$acution->price_opining}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label> سعر الانتهاء </label>
                            <span  class="form-control">{{$acution->price_closing}}</span>
                        </div>
                    </div>

                    <div class="col-md-8">

                        <div class="form-group col-md-6">
                            <label>اعلي سعر</label>
                            <span  class="form-control">{{$acution->price}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>الحاله</label>
                            <span  class="form-control">
                                @if ($acution->status == 0)
                                    مفعل
                                @else
                                    غير مفعل
                                @endif
                            </span>
                        </div>
                    </div>


                    <div class="col-md-8">

                        <div class="form-group col-md-6">
                            <label>وقت البداء</label>
                            <span  class="form-control">{{$acution->start_data}}</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>وقت الانتهاء</label>
                            <span  class="form-control">{{$acution->end_data}}</span>
                        </div>
                    </div>


                    <div class="col-md-8">

                        <div class="form-group col-md-6">
                            <label>الحاله</label>
                            <span  class="form-control">
                                @if ($acution->is_finished == 0)
                                    مستمر
                                @else
                                    مزاد منتهي
                                @endif
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>حاله المزاد</label>
                            <span  class="form-control">
                                    @if ($acution->status == 0)
                                        مستمر
                                    @else
                                        مزاد ملغي
                                    @endif
                            </span>
                        </div>
                    </div>



                    <div class="col-md-8">
                        <div class="form-group col-md-6">
                            <label>التفاصيل</label>
                            <textarea name="" id="" class="form-control ckeditor" cols="30" rows="10" disabled>{{$acution->detials}}</textarea>
                        </div>


                    </div>


                    <div class="col-md-12">

                        <div class="form-group col-md-6">
                            <label> القسم </label>
                            <span  class="form-control">{{$acution->category->category_name_ar}}</span>
                        </div>

                        <div class="col-md-12">
                            <label> تفاصيل القسم </label>
                            @foreach ($detials as $detial)
                                <span  class="form-control" style="color: blue">{{$detial->cat_parm->param_name_ar}}</span><br>
                                <span  class="form-control">{{isset($detial->param_value) ? $detial->param_value : $detial->type->param_name_ar}}</span><br>
                            @endforeach
                        </div>


                    </div>
                    <div class="col-md-12">

                        <div class="form-group col-md-6">
                            <label>صور المزاد</label><br>
                            @foreach ($images as $image)
                                <img src="{{asset('uploads/acution/'.$image->img)}}" width="200" height="200" alt="" srcset="">
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
