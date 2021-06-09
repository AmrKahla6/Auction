@extends('layouts.online.member')
@section('content')

<div id="login-content">
    <div class="content">
        <div class="login-box">
            @include('partials._errors')
            @include('partials._session')
                <form action="{{route('live.post_auctions')}}" id="myform" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-6">
                            <label>  اسم  المزاد </label>
                        <input type="text"  required="required" name="auction_title" value="" placeholder="اسم المزاد"  class="form-control">
                       </div>
                       <div class="col-md-6">
                        <label>  السعر </label>
                        <input type="number"  required="required" name="price" value="" placeholder="السعر"  class="form-control">
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                        <label>  العنوان</label>
                        <input type="text" name="address"  required="required" value="" placeholder="العنوان"  class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label> سعر الافتتاح</label>
                        <input type="number"  required="required" name="price_opining" value="" placeholder="سعر الافتتاح"  class="form-control">
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-12 form-group ">
                        <label> سعر الإغلاق</label>
                        <input type="number"  required="required" name="price_closing" value="" placeholder="سعر الاغلاق"  class="form-control">
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label> نوع العرض </label>
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
                        <label>تاريخ الاغلاق</label>
                        <input type="date"  required="required" onchange="check_date()" id="end_data" name="end_data" value="" placeholder="end_data"  class="form-control">
                    </div>
                    </div>
                    <div class="row">
                        <label> تفاصيل </label>
                  <div class="col-md-12 form-group">
                        <textarea type="text"  required="required" name="detials" placeholder="تفاصيل"  class="form-control"></textarea>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>الوصف بالعربي </label>
                        <input type="text"  required="required" name="desc_ar" value="" placeholder="الوصف بالعربي"  class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label> الوصف بالانجليزية </label>
                        <input type="text"  required="required" name="desc_en" placeholder="الوصف بالانجليزية"  class="form-control">
                    </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>  المحافظة </label>
                        <select name="gover_id"  required="required" id="gover_id" class="form-control"  onchange="get_Cites()">
                            <option disabled="disabled" value="-1"> المحافظة</option>
                            @foreach ($governorate as $gov)
                            <option value="{{$gov->id}}">{{$gov->name}}</option>
                            @endforeach
                        </select>
                      </div>
                        <div class="col-md-6 form-group">
                            <label>  المدينة </label>
                        <select name="city_id"  required="required" class="form-control" id="city_id">
                        </select>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>   الصور  </label>
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
                        <label>   القسم  </label>
                        <select name="cat_id" id="cat_id" class="form-control" onchange="Get_Params()" required="required">
                            <option disabled="disabled"  value="-1">القسم </option>
                            @foreach ($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                 {{-- @foreach ($cat->subcategory()->select('id','category_name_' . LaravelLocalization::getCurrentLocale() . ' as name',)->get() as $sub)
                                    <option value="{{$sub->id}}">{{$sub->name}}</option>
                                @endforeach --}}
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
    $("#city_id").html("");
   $("#city_id").html(data);
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

</script>
<script>
    function Stat_Date_option() {
        $("#Stat_Date").html("");
        if($("#type_id option:selected").val() > 1){
           // alert($("#type_id option:selected").val());
        $("#Stat_Date").html('<div class="col-md-12 form-group">\
         <label>تاريخ البدء</label>\
         <input type="date" name="start_data" onchange="check_date()" id="start_data" class="form-control"value="" placeholder="تاريخ الافتتاح"  class="form-control">\
                    </div>');
                    $("#start_data").date({
                     minDate: new Date() ,
                    dateFormat: 'dd/mm/yy',
                    changeYear:true,
                    changeMonth:true,
  });
                }else{
                    $("#Stat_Date").html("");
                }
    }

    //end date
$(document).ready(function() {
 get_Cites();
Get_Params();
const today = new Date();
 const tomorrow = new Date(today);
  $("#end_data").date({
    minDate: new Date() ,
  	dateFormat: 'dd/mm/yy',
	changeYear:true,
	changeMonth:true,
    changeDay:true,
  });


});

function check_date(){
    var endDate = $('#end_data').val();
    var startDate = $('#start_data').val();
    var toDay = new Date();
    if($('#end_data').val()!="" && $('#end_data').val() != undefined ){
	if(Date.parse(endDate) <= new Date()){
		alert("you are not allowed to select past date");
		$('#end_data').val('');
	}
}
    if($('#start_data').val()!="" && $('#start_data').val() != undefined ){
        if(Date.parse(startDate) < new Date()){
		alert("you are not allowed to select past date");
		$('#start_data').val('');
	}
}
if($('#start_data').val()!="" && $('#end_data').val()!=""){
  if(Date.parse(endDate) <= Date.parse(startDate)){
		alert("you are not allowed to select invalid date");
		//$('#start_data').val('');
        $('#end_data').val('');
	}
}

}
</script>


@endsection
