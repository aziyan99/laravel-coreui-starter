@if ($logo == null)
    <img class="sidebar-brand-full"
         src="{{ $logo }}" alt="brand"
         height="46">
    <img class="sidebar-brand-narrow"
         src="{{ $logo }}" alt="brand"
         height="46">
@else
    <img class="sidebar-brand-full"
              src="{{ asset($logo) }}" alt="brand"
              height="46">
    <img class="sidebar-brand-narrow"
         src="{{ asset($logo) }}" alt="brand"
         height="46">
@endif
