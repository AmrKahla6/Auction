<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            <form action="{{ route('dashboard.governorates.cities.store' , $governorate) }}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label>المدينه بالعربيه</label>
                    <input type="text" name="city_name_ar" class="form-control" value="{{ old('city_name_ar') }}" >
                </div>
                <div class="form-group">
                    <label>المدينه بالعربيه</label>
                    <input type="text" name="city_name_en" class="form-control" value="{{ old('city_name_en') }}" >
                </div>
                <input type="hidden" name="governorate_id" value="{{$governorate->id}}">
                <div class="form-group">
                    @if(auth()->user()->hasPermission('create_cities'))
                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    @else
                        <button class="btn btn-primary" disabled><i class="fa fa-plus"></i>@lang('site.add')</button>
                    @endif
                </div>

            </form>
        </div>
    </div>

</section><!-- end of content -->
