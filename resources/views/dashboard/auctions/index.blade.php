@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المزادات
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1> المزادات </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i>المزادات</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">المشرفين
                        <small>{{ $acutions->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.auction.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($acutions->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th> العضو</th>
                                <th>عنوان المزاد</th>
                                <th>حاله الانتهاء</th>
                                <th>حاله الالغاء</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($acutions as $index => $acution)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ isset($acution->member->username ) ? $acution->member->username : $acution->member->email}}</td>
                                    <td>{{ $acution->auction_title }}</td>
                                    <td>
                                        @if ($acution->is_finished == 0)
                                        <span class="badge badge-light">مزاد مستمر</span>
                                        @else
                                        مزاد منتهي
                                        @endif
                                    </td>
                                    <td>
                                        @if ($acution->status == 0)
                                            <span class="badge badge-light">مستمر</span>
                                        @else
                                            مزاد ملغي
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                            href="{{route('dashboard.auction.tenders-index' , $acution->id)}}">
                                            <i class="fa fa-edit"></i>
                                                    المزايدات
                                        </a>


                                        @if ($acution->is_slider == 0)
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $acution->id }}" data-toggle="modal"
                                                href="#exampleModal2" title="اضافه الي السلايدر"><i class="fa fa-sliders">سلايدر</i>
                                            </a>
                                        @else
                                            <form method="post"
                                                    action="{{route('dashboard.auction.slider-delete' , $acution->id)}}"
                                                    style="display: inline-block">
                                                @csrf()
                                                <button type="submit" title="حذف من السلايدر" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-sliders"></i>سلايدر</button>
                                            </form>
                                        @endif

                                        <a class="btn btn-info btn-sm"
                                            href="{{route('dashboard.auction.show' , $acution->id)}}"><i
                                                    class="fa fa-edit"></i>عرض</a>

                                            <form method="post"
                                                  action="{{route('dashboard.auction.destroy' , $acution->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fa fa-trash"></i>حذف</button>
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $acutions->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد مشرفين</h2>
                    @endif

                </div>
            </div>
            @include('dashboard.auctions.slider')
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

@section('scripts')
    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

    </script>
@endsection
