<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            <form action="{{ route('dashboard.cats.params-store' , $category) }}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label>الخاصيه بالعربيه</label>
                    <input type="text" name="param_name_ar" class="form-control" value="{{ old('param_name_ar') }}" >
                </div>
                <div class="form-group">
                    <label>الخاصيه بالانجليزيه</label>
                    <input type="text" name="param_name_en" class="form-control" value="{{ old('param_name_en') }}" >
                </div>

                <div class="form-group">
                    <label>النوع</label>
                    <select name="type" id="" class="form-control">
                        <option value="" selected disabled>اختر النوع</option>
                        <option value="1">حقل نص</option>
                        <option value="2">اختيار متعدد</option>
                    </select>
                </div>


                <input type="hidden" name="cat_id" value="{{$category->id}}">
                <div class="form-group">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')</button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->
