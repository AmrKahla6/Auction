@extends('layouts.dashboard.app')

@section('content')
@section('title')
     الشائعه
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>  الاسئله الشائعه </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> الرئيسيه </a>
                </li>
                <li class="active"></i> الاسئله الشائعه</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;"> الاسئله الشائعه
                        <small>{{ $questions->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.questions.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>بحث</button>
                                @if(auth()->user()->hasPermission('create_common_questions'))
                                    <a href="{{ route('dashboard.questions.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>اضافه</a>
                                @else
                                    <a class="btn btn-plus" href="#" disabled>اضافه</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($questions->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>السؤال</th>
                                <th>الاجابه</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($questions as $index => $question)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $question->question_ar }}</td>
                                    <td>{!! substr($question->answer_ar, 0, 50) !!} ..... <a href="{{route('dashboard.questions.show',$question->id)}}"><small>مشاهده المزيد</small></a></td>
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_common_questions'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.questions.edit' , $question->id)}}"><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>تعديل</a>
                                        @endif


                                        @if(auth()->user()->hasPermission('delete_common_questions'))
                                            <form method="post"
                                                  action="{{route('dashboard.questions.destroy' , $question->id)}}"
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
                        {{ $questions->appends(request()->query())->links() }}
                    @else
                        <h2>لا يوجد اسئله</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
