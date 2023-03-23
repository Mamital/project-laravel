@extends('admin.layouts.master')

@section('head-tag')
<title>گالری</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> گالری</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                 گالری
                </h5>
            </section>

            <section class="d-flex  align-items-center mt-4 mb-3 border-bottom pb-2">
                     <div class="p-2">
                    <a href="{{ route('admin.market.gallery.create', $product->id) }}" class="btn btn-info btn-sm p-2">ایجاد رنگ
                        جدید</a>
                     </div>
                        <div class="p-2">
                    <a href="{{ route('admin.market.product.index') }}" class="btn btn-info btn-sm p-2">بازگشت</a>
                    </div>
                    <div class="max-width-16-rem mr-auto p-2">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px">
                    <thead>                        
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th> تصویر کالا</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $productImage)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>{{$product->name}}</td>
                            <td>
                                <img src="{{ asset($productImage->image['indexArray'][$productImage->image['currentImage']]) }}"  alt="" class="max-height-2rem" width="100">
                            </td>
                            <td class="width-16-rem text-left">
                                        <form class="d-inline"
                                            action="{{ route('admin.market.gallery.destroy', ['product' => $product->id, 'gallery' => $productImage->id]) }}"
                                            method="post">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                    class="fa fa-trash-alt"></i> حذف</button>
                                        </form>
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
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
