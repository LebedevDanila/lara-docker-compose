<ul class="{{ $classname ?? '' }}" itemscope itemtype="http://schema.org/BreadcrumbList">
    @foreach ($data as $key => $row)
        <li itemscope itemprop="itemListElement"  itemtype="http://schema.org/ListItem">
            <a href="{{ $row['link'] }}" itemprop="item">{{ $row['name'] }}</a>
            <meta itemprop="position" content="{{ $key + 1 }}" />
            @if ($key !== count($data)-1)
                <span class="__ARROW" >/</span>
            @endif
        </li>
    @endforeach
</ul>