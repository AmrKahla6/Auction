@extends('layouts.dashboard.app')

@section('content')
@section('title')
    ايام العطلات الثابته
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1> ايام العطلات الثابته </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> ايام العطلات الثابته </li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;"> ايام العطلات الثابته
                        <small>{{ $days->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.get-days-of') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                    {{-- <a href="{{ route('dashboard.governorates.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a> --}}
                                    <a class="modal-effect btn btn-primary" data-effect="effect-fall" data-toggle="modal" href="#modaldemo8">@lang('site.add')</a>
                            </div>
                        </div>

                    </form>
                </div>

                @include('partials._errors')
                @include('partials._session')
                <div class="box-body">

                    @if($days->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>اليوم</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($days as $index => $day)
                                {{-- @php
                                    if ($day == 7) {
                                        $day = "الجمعة";
                                    }
                                    if ($day == 1) {
                                        $day = "السبت";
                                    }
                                    if ($day == 2) {
                                        $day = "الأحد";
                                    }
                                    if ($day == 3) {
                                        $day = "الاثنين";
                                    }
                                    if ($day == 4) {
                                        $day = "الثلاثاء";
                                    }
                                    if ($day == 5) {
                                        $day = "الأربعاء";
                                    }
                                    if ($day == 6) {
                                        $day = "الخميس";
                                    }
                                @endphp --}}
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>
                                    @if ($day->day == "Saturday")
                                          السبت
                                    @endif
                                    @if ($day->day == "Sunday")
                                        الاحد
                                    @endif
                                    @if ($day->day == "Monday")
                                        الاتنين
                                    @endif
                                    @if ($day->day == "Tuesday")
                                         الثلاثاء
                                    @endif
                                    @if ($day->day == "Wednesday")
                                        الاربع
                                    @endif
                                    @if ($day->day == "Thursday")
                                        الخميس
                                    @endif

                                    @if ($day->day == "Friday")
                                        الجمعه
                                    @endif

                                    </td>
                                    <td>
                                    <form method="post"
                                            action="{{route('dashboard.delete-static-days-of' , $day->id)}}"
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
                        {{ $days->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>
            @include('dashboard.static_days.create')
            @include('dashboard.static_days.edit')
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
@section('scripts')
<script>
    //Edit Phone
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id  = button.data('id')
        var day = button.data('day')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #days_of').val(day);
    })
</script>
@endsection
