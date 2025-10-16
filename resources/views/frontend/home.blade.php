{{-- resources/views/home.blade.php --}}
<x-layout-user :categories="$categories">
       <x-banner-section />
       <x-brand-showcase />

<x-product-sale />
<x-product-new />
<x-post-section />

</x-layout-user>
