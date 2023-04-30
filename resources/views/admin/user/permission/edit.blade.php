@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش دسترسی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">مدیریت دسترسی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش دسترسی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش دسترسی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.permission.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <section class="row">

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">نام دسترسی</label>
                                    <input type="text" class="form-control form-control-sm" name="name" value="{{old('name', $permission->name)}}">
                                </div>
                                @error('name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" permission="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">توضیح دسترسی</label>
                                    <input type="text" class="form-control form-control-sm" name="description" value="{{old('description', $permission->description)}}">
                                </div>
                                @error('description')
                                    <span class="alert_required bg-danger text-white p-1 rounded" permission="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-2">
                                <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                            </section>

                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
