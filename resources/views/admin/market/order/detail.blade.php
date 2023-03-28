@extends('admin.layouts.master')

@section('head-tag')
<title>جزئیات سفارشات</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> جزئیات سفارشات</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                 جزئیات سفارشات
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="" class="btn btn-info btn-sm disabled">ایجاد سفارش </a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام محصول</th>
                            <th>درصد فروش فوق العاده </th>
                            <th>مبلغ فروش فوق العاده </th>
                            <th>تعداد</th>
                            <th>جمع قیمت محصول</th>
                            <th>قیمت نهایی محصول</th>
                            <th>رنگ</th>
                            <th>گارانتی </th>
                            <th>ویژگی</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($order->orderItems as $item)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $item->singleProduct->name ?? '-' }}</td>
                            <td>{{ $item->amazingSale->percentage ?? '-' }}</td>
                            <td>{{ $item->amazing_sale_discount_amount ?? '-' }} تومان</td>
                            <td>{{ $item->number }}</td>
                            <td>{{ $item->final_product_price ?? '-' }}</td> تومان</td>
                            <td>{{ $item->final_total_price ?? '-'}}</td>
                            <td>{{ $item->color->color_name ?? '-' }}</td>
                            <td>{{ $item->guarantee->name ?? '-' }}</td>
                            <td>
                                @forelse($item->orderItemAttributes as $attribute)
                                {{ $attribute->categoryAttribute->name ?? '-' }}
                                :
                                {{ json_decode($attribute->categoryAttributeValue->value)->value ?? '-' }}
                                @empty
                                -
                                @endforelse
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection
