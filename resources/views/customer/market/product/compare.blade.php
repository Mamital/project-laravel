@extends('customer.layouts.master-one-col')

@section('content')
    @if ($products->count() > 0)
        <section class="lazyload-wrapper" style="margin-right: 5rem" id="compare-products">
            <section class="d-flex justify-content-around">
                @foreach ($products as $product)
                    <section class="item">
                        <section class="lazyload-item-wrapper">
                            <section class="product">
                                <section class="product-add-to-cart"><a
                                        href="{{ route('home.profile.my-compare.remove', $product) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از مقایسه"><i
                                            class="fa fa-trash"></i></a>
                                </section>
                                <a class="product-link" href="{{ route('home.product.index', $product->slug) }}">
                                    <section class="product-image">
                                        <img class="" src="{{ asset($product->image['indexArray']['medium']) }}"
                                            alt="{{ $product->slug }}">
                                    </section>
                                    <section class="product-name">
                                        <h3>{{ $product->name }}</h3>
                                    </section>
                                    <section class="">
                                        {{ priceFormat($product->price) }}</section>
                            </section>
                            </a>
                        </section>
                    </section>
                @endforeach
            </section>
        </section>
        <table class="table table-striped table-bordered" id="compare-table">

            @if ($properties->count() > 0)
                @foreach ($properties as $property)
                    <tr>

                        <td style="width: 8rem">{{ $property->name }}</td>
                        @foreach ($products as $product)
                            <td style="text-align: center">
                                @foreach ($property->values as $value)
                                    @if ($value->product_id == $product->id)

                                        {{ $value->value }} {{ $value->attribute->unit }}

                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endif

            @if($product->metas->count())


            <tr>
                <td style="width: 8rem">سایر مشخصات</td>
                @foreach ($products as $product)
                    <td style="text-align: center">
                        @foreach ($product->metas as $meta)
                            {{ $meta->meta_key }} : {{ $meta->meta_value }} <br>
                        @endforeach
                    </td>
                @endforeach
            </tr>

            @endif

        </table>
    @else
        <h2 style="text-align: center" class="m-5">محصولی برای مقایسه انتخاب نشده است</h2>
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if (screen.width > 0 && screen.width < 480) {
                var products = $('#compare-products');
                console.log(products);
                products.css({
                    'margin-right': '0px'
                })
                var table = $('#compare-table');
                table.css({
                    'font-size': '12px'
                })
            }
        });
    </script>
@endsection
