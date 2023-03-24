@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش تخفیف عمومی</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">برند</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تخفیف عمومی</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ویرایش تخفیف عمومی
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.discount.commonDiscount') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{route('admin.market.discount.commonDiscount.update', $commonDiscount->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">درصد تخفیف</label>
                                <input type="text" class="form-control form-control-sm" name="percentage" value="{{old('percentage', $commonDiscount->percentage)}}">
                            </div>
                            @error('percentage')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">حداکثر تخفیف</label>
                                <input type="text" class="form-control form-control-sm" name="discount_ceiling" value="{{old('discount_ceiling', $commonDiscount->discount_ceiling)}}">
                            </div>
                            @error('discount_ceiling')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                         <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">تاریخ شروع</label>
                                <input type="text" name="start_date" id="start_date" class="form-control form-control-sm d-none"  />
                                <input type="text" id="start_date_view" class="form-control form-control-sm" value="{{ $commonDiscount->start_date}}">
                            </div>
                            @error('start_date')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>
                         <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">تاریخ پایان</label>
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm d-none" >
                                <input type="text" id="end_date_view" class="form-control form-control-sm" value="{{ $commonDiscount->end_date }}">
                            </div>
                            @error('end_date')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>

                           <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">حداقل تخفیف</label>
                                <input type="text" class="form-control form-control-sm" name="minimal_order_amount" value="{{old('minimal_order_amount', $commonDiscount->minimal_order_amount)}}">
                            </div>
                            @error('minimal_order_amount')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="">عنوان مناسبت</label>
                                <input type="text" class="form-control form-control-sm" name="title" value="{{old('title',$commonDiscount->title)}}">
                            </div>
                            @error('title')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
              
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
@section('script')
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        CKEDITOR.replace('introduction');
    </script>
    <script>
        $(document).ready(function() {
            $('#start_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#start_date'
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#end_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#end_date'
            })
        });
    </script>
@endsection