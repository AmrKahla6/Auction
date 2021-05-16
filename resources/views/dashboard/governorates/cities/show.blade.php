
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">المدن
                {{-- <small>{{ $citys->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($cities->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>المدينه بالعربيه</th>
                        <th>المدينه بالانجليزيه</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($cities as $index => $city)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $city->city_name_ar }}</td>
                            <td>{{ $city->city_name_en }}</td>
                            <td>
                                <form method="post"
                                    action="{{route('dashboard.governorates.cities.destroy' , ['governorate'=>$city->governorate->id,'city'=>$city->id])}}"
                                    style="display: inline-block">
                                    @csrf()
                                    @method('delete')
                                    @if(auth()->user()->hasPermission('delete_cities'))
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    @else
                                        <button class="btn btn-danger btn-sm delete" disabled><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                {{ $cities->appends(request()->query())->links() }}

            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->
