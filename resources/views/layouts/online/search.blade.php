
<form action="{{ route('live.myonline') }}" method="get" autocomplete="off">
    <div class="col-sm-4 col-xs-6">
        <div id="search" class="input-group">
            <input type="text" name="search" value="{{ request()->search }}" placeholder="@lang('live.search')" class="">
            <button type="submit" class=""><span class="icon-search1"></span></button>
        </div>
    </div>
</form>


