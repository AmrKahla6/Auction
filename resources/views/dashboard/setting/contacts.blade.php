@extends('layouts.dashboard.app')

@section('content')
@section('title')
    الرسائل
@endsection
    <div class="content-wrapper">

        <section class="content-header">

            <h1>تواصل معانا
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i>الرسائل</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">الرسائل
                        <small>{{ $contacts->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.setting-contact') }}" method="get">
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

                    @if($contacts->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>  اسم العميل</th>
                                <th>  الرساله</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $index => $contact)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ isset($contact->member->username) ? $contact->member->username : $contact->member->email  }}</td>
                                    <td>{{ $contact->message }}</td>
                                    <td>
                                        <form method="post"
                                                action="{{route('dashboard.setting-contact-delete' , $contact->id)}}"
                                                style="display: inline-block">
                                            @csrf()
                                            @method('delete')
                                            @if(auth()->user()->hasPermission('delete_contacts'))
                                                <button type="submit" title="حذف الرساله !" class="btn btn-danger btn-sm delete"><i
                                                    class="fa fa-trash"></i>@lang('site.delete')</button>
                                            @else
                                                <button class="btn btn-danger" disabled><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                            @endif

                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $contacts->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
