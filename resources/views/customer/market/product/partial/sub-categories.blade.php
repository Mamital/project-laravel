@foreach ($categories as $category)
    <section class="sidebar-nav-sub-wrapper">
        <section class="sidebar-nav-sub-item">
            <span class="sidebar-nav-sub-item-title">
                <a class="d-inline {{$category->id == request()->productCategory->id ? 'text-danger' : ''}} " href="{{route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, $category->id])}}">{{$category->name}}</a>
                @if($category->children->count() > 0)
                <i class="fa fa-angle-left"></i>
                @endif
            </span>
            @include('customer.market.product.partial.sub-categories', ['categories' => $category->children])
        </section>
    </section>
@endforeach
