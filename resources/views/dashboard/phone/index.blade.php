@extends('layouts.dashboard.app')

@section('content')
@section('title')
     ارقام الشركه
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>  ارقام الشركه </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i> ارقام الشركه</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;"> ارقام الشركه
                        <small>{{ $phones->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.setting-get-phone') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                    <a class="modal-effect btn btn-primary" data-effect="effect-fall" data-toggle="modal" href="#modaldemo8">
                                        <i class="fa fa-plus"></i>
                                        اضافه
                                    </a>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($phones->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>رقم الهاتف</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($phones as $index => $phone)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $phone->number }}</td>
                                    </td>
                                    <td>
                                        {{-- <a class="btn btn-info btn-sm"
                                            href="{{route('dashboard.questions.edit' , $phone->id)}}"><i
                                                    class="fa fa-edit"></i>تعديل</a> --}}

                                        <a class="modal-effect btn btn-info btn-sm" data-effect="effect-scale"
                                            data-id="{{ $phone->id }}" data-number="{{ $phone->number }}"
                                            data-toggle="modal"
                                            href="#exampleModal2" title="تعديل"><i class="fa fa-edit"></i>
                                            تعديل
                                        </a>
                                            <form method="post"
                                                  action="{{route('dashboard.setting-delete-phone' , $phone->id)}}"
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
                        {{ $phones->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد ارقام للهاتف</h2>
                    @endif

                </div>
            </div>
            @include('dashboard.phone.create')
            @include('dashboard.phone.edit')
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
@section('scripts')
<script>
    //Edit Phone
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var number = button.data('number')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #edit_number').val(number);
    })
</script>
@endsection
