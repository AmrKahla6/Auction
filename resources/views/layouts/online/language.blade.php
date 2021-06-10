<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    اللغه
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a rel="alternate" hreflang="{{ $localeCode }}" class="btn btn-language dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            <span class="icon-earth"></span> {{ $properties['native'] }}
        </a>
    @endforeach
  </div>
