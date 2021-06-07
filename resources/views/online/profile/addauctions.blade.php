@extends('layouts.online.member')
@section('content')
<div id="login-content">
    <div class="content">
        <div class="login-box">
            @include('partials._errors')
            @include('partials._session')
                <form action="{{route('live.post_auctions')}}" id="myform" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-6">
                            <label>  @lang('live.auction_name') </label>
                            <input type="text"  required="required" name="auction_title" value="{{ old('auction_title') }}" placeholder="@lang('live.auction_name')"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>  @lang('live.price') </label>
                            <input type="number"  required="required" name="price" value="{{ old('price') }}" placeholder="@lang('live.price')"  class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>  @lang('live.address')</label>
                            <input type="text" name="address"  required="required" value="{{ old('address') }}" placeholder="@lang('live.address')"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label> @lang('live.open_price')</label>
                            <input type="number"  required="required" name="price_opining" value="{{ old('price_opining') }}" placeholder=" @lang('live.open_price')"  class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group ">
                            <label> @lang('live.close_price') </label>
                            <input type="number"  required="required" name="price_closing" value="{{ old('price_closing') }}" placeholder=" @lang('live.close_price')"  class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label> @lang('live.show_type') </label>
                        <select name="type_id" id="type_id" onchange="Stat_Date_option()" required="required" class="form-control">
                            @foreach ($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="row"  id="Stat_Date">
                        </div>
                    <div class="row">

                    <div class="col-md-12 form-group">
                        <label>@lang('live.date_close')</label>
                        <input type="date"  required="required" name="end_data" value="{{ old('end_data') }}" placeholder="@lang('live.date_close')"  class="form-control">
                    </div>
                    </div>
                    <div class="row">
                        <label> @lang('live.detials') </label>
                        <div class="col-md-12 form-group">
                            <textarea type="text"  required="required" name="detials" placeholder="@lang('live.detials')"  class="form-control">{{ old('detials') }}</textarea>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6 form-group">
                            <label>الوصف بالعربي </label>
                        <input type="text"  required="required" name="desc_ar" value="" placeholder="الوصف بالعربي"  class="form-control">
                    </div> --}}
                    {{-- <div class="col-md-6 form-group">
                        <label> الوصف بالانجليزية </label>
                        <input type="text"  required="required" name="desc_en" placeholder="الوصف بالانجليزية"  class="form-control">
                    </div> --}}
                    </div>


                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>  @lang('live.governorate') </label>
                        <select name="gover_id"  required="required" id="gover_id" class="form-control"  onchange="get_Cites()">
                            <option disabled="disabled" value="-1"> @lang('live.governorate')</option>
                            @foreach ($governorate as $gov)
                                 <option value="{{$gov->id}}">{{$gov->name}}</option>
                            @endforeach
                        </select>
                      </div>
                        <div class="col-md-6 form-group">
                            <label>  @lang('live.city') </label>
                        <select name="city_id"  required="required" class="form-control" id="city_id">
                        </select>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>   @lang('live.images')  </label>
                            <input type="file"  required="required" onchange="loadPreview(this)" id="file-input" class="form-control" name="auction_images[]" multiple="true" accept="image/*" >
                            @if ($errors->has('files'))
                                @foreach ($errors->get('files') as $error)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                @endforeach
                            @endif
                            <div id="thumb-output"></div>
                            <br>
                       </div>
                    </div>
                    <div class="row">
                     <div class="col-md-12 form-group">
                        <label>   @lang('live.category')  </label>
                        <select name="cat_id" id="cat_id" class="form-control" onchange="Get_Params()" required="required">
                            <option disabled="disabled"  value="-1">@lang('live.category')   </option>
                            @foreach ($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                             @foreach ($cat->subcategory()->select('id','category_name_' . LaravelLocalization::getCurrentLocale() . ' as name',)->get() as $sub)
                                <option value="{{$sub->id}}">{{$sub->name}}</option>
                             @endforeach
                            @endforeach
                        </select>
                    </div>
                    </div>

                   <div id="ParamsHouse"></div>

                    <div class="login-box-footer">
                        <button  type="submit"id="add_build"  class="btn btn-block btn-lg btn-primary">حفظ المزاد</button>
                    </div>
                </form>
                </div>
            </div>
            </div>




    <script>
   function loadPreview(input){
       var data = $(input)[0].files; //this file data
       $.each(data, function(index, file){
           if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
               var fRead = new FileReader();
               fRead.onload = (function(file){
                   return function(e) {
                       var img = $('<img width = "100" height = "100"/>').addClass('thumb').attr('src', e.target.result); //create image thumb element
                       $('#thumb-output').append(img);
                   };
               })(file);
               fRead.readAsDataURL(file);
           }
       });
   }
</script>
<script>
 function get_Cites(){
  var gover_id = $("#gover_id").find("option:selected").val();
  if(gover_id > 0 ){
  $.get('/live/get_cites/'+gover_id,function(data){
   // console.log(data)
   $("#city_id").append(data);
  })
}else{
  $("#city_id").html("");
}
}
</script>

<script>
 function Get_Params(){
  var cat_id = $("#cat_id").find("option:selected").val();
  if(cat_id > 0 ){
   $.get('/live/get_params/'+cat_id,function(data){
        $("#ParamsHouse").html(data);
    });
    }else{
    $("#ParamsHouse").html("");
    }
}
    get_Cites();
    Get_Params();
</script>
<script>
    function Stat_Date_option() {
        $("#Stat_Date").html("");
        if($("#type_id option:selected").val() > 1){
           // alert($("#type_id option:selected").val());
        $("#Stat_Date").html('<div class="col-md-12 form-group">\
         <label>  @lang('live.start_date')</label>\
         <input type="date" name="start_data" value="" placeholder="@lang('live.start_date')"  class="form-control">\
                    </div>');
                }else{
                    $("#Stat_Date").html("");
                }
    }
</script>
@endsection
