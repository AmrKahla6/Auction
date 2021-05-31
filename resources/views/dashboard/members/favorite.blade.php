@extends('layouts.dashboard.app')

@section('content')
@section('title')
    المفضله
@endsection

    <div class="content-wrapper">

        <section class="content-header">

            <h1>  المفضله </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><a href="{{route('dashboard.members.index')}}"></i>الاعضاء</li></a>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 10px;">{{ isset($member->username) ? $member->username : $member->email }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <section class="content">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title" style="margin-bottom: 10px;">
                                            <small>{{ $favorites->total() }}</small> المفضله
                                        </h3>
                                    </div>
                                    <div class="box-body">

                                        @if($favorites->count() > 0)
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th> عنوان المزاد</th>
                                                    <th>@lang('site.action')</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($favorites as $index => $favorite)
                                                    <tr>
                                                        <td>{{ $index +1 }}</td>
                                                        <td>{{ $favorite->auction->auction_title }}</td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm"
                                                                href="{{route('dashboard.auction.show' , $favorite->auction->id)}}"><i
                                                                    class="fa fa-edit"></i>عرض</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
                                            {{ $favorites->appends(request()->query())->links() }}

                                        @else
                                            <h2>@lang('site.no_data_found')</h2>
                                        @endif

                                    </div>
                                </div>

                            </section><!-- end of content -->

                        </div>
                    </div>

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
