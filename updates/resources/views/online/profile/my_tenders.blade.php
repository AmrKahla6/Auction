@extends('layouts.online.member')
@section('content')
	
<div class="mybids-tabs">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#thewinner">الرابحة</a></li>
            <li><a data-toggle="tab" href="#expected">المنتظرة</a></li>
        </ul>
    </div>
</div>
<div class="tab-content">
    <div id="thewinner" class="tab-pane in active">
        <div class="mybids-boxs">
            <div class="container">
                <div class="row">
                    @if($active_tenders->count() > 0)
                    @foreach ( $active_tenders as $tender )
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mybids-box">
                            <div class="mybids-about">
                                <div>
                                    <p>مبلغ المزايدة</p>
                                    <b>{{$tender->price}} </b>
                                </div>
                                <div>
                                 
                                </div>
                            </div>
                            <div class="mybids-winner">
                                <div class="the-win">
                                    <h5></h5>
                                </div>
                                <div class="mybids-winner-content">
                                    <div class="image"><img src="{{ asset('online/images/images/user.png')}}" class="img-responsive" /></div>
                                    <div class="winner-user">
                                        <h5>{{$member->username}}</h5>
                                        <p>{{$member->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                    @endforeach
                    @else
                    <div>
                        <p> ليس هناك مزايدات </p>
               
                    </div>
                    @endif
              
                </div>
            </div>
        </div>
    </div>
    <div id="expected" class="tab-pane">
        <div class="mybids-boxs">
            <div class="container">
                <div class="row">
                    @if($dis_tenders->count() > 0)
                    @foreach ( $dis_tenders as $tender )
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mybids-box">
                            <div class="mybids-about">
                                <div>
                                    <p>مبلغ المزايدة</p>
                                    <b>{{$tender->price}} </b>
                                </div>
                                <div>
                                 
                                </div>
                            </div>
                            <div class="mybids-winner">
                                <div class="the-win">
                                    <h5></h5>
                                </div>
                                <div class="mybids-winner-content">
                                    <div class="image"><img src="{{ asset('online/images/images/user.png')}}" class="img-responsive" /></div>
                                    <div class="winner-user">
                                        <h5>{{$member->username}}</h5>
                                        <p>{{$member->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                    @endforeach
                    @else
                    <div>
                        <p> ليس هناك مزايدات </p>
               
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection