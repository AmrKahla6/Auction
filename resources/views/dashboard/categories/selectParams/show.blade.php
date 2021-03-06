
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">الخصائص
                {{-- <small>{{ $citys->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($selected->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>الخاصيه بالعربيه</th>
                        <th>الخاصيه بالانجليزيه</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($selected as $index => $param)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $param->param_name_ar }}</td>
                            <td>{{ $param->param_name_en }}</td>
                            <td>
                                <form method="post"
                                    action="{{route('dashboard.cats.params-selected-destroy' , ['params'=>$param->param->id,'selected'=>$param->id])}}"
                                    style="display: inline-block">
                                    @csrf()
                                    @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                {{ $selected->appends(request()->query())->links() }}

            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->
