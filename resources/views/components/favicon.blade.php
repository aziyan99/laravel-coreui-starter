@if ($logo == null)
    <link rel="icon" type="image/x-icon" href="{{ $logo }}">
@else
    <link rel="icon" type="image/x-icon" href="{{ asset($logo) }}">
@endif
