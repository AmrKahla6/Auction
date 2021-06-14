@if (App::isLocale('en'))
<a class="btn btn-language"  href="{{changeLang()}}">
    <span class="icon-earth"></span>
    عربي
</a>
@else
<a class="btn btn-language" rel="alternate" hreflang="#" href="{{changeLang()}}">
    <span class="icon-earth"></span>
    English
</a>
@endif
