<div class="container">
    <div class="head-title">
        <h3>تصفح الأقسام</h3>
        <p>أختر القسم الذي تريدة</p>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                @foreach ($categories as $cat )
                <div class="col-sm-3 col-xs-3">
                    <a href="{{route('live.sub_categories',$cat->id)}}" class="category">
                        <div class="image">
                            <span class="count">{{ $cat->subcategory()->count()}}</span>
                            <img src="{{asset('uploads/category/'.$cat->img) }}" class="img-responsive" />
                        </div>
                        <p>{{$cat->category_name_ar}}</p>
                    </a>
                </div>
                @endforeach
            
           
        
            </div>
        </div>
   
    </div>
</div>