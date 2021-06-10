@extends('layouts.online.member')
@section('content')
<div class="page-title">
    <div class="container">
        <div class="head-title">
            <h3>@lang('live.repeat_question')</h3>
            <p>@lang('live.hope_quetions')</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div id="mainfaq" class="page-content">
                <div class="faq-questions">
                    <ul>
                        @foreach ($questions as $index => $item)
                            <li>
                                <a href="#question-{{$item->id}}">{{$index+1}}. {{$item->question}}؟ </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @foreach ($questions as $index => $item)
                    <div id="question-{{$item->id}}" class="faq-answer">
                        <h3>{{$index+1}}.    {{$item->question}}   ؟</h3>
                        <p>  {{$item->answer}} </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
