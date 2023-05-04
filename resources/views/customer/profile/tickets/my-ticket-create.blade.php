@extends('customer.layouts.master-two-col')
@section('head-tag')
    <title>افزودن تیکت</title>
@endsection

@section('customer.layouts.sidebar')
    @include('customer.profile.sidebar')
@endsection
@section('content')
    <main id="main-body" class="main-body col-md-9">
        <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

            <!-- start vontent header -->
            <section class="content-header">
                <section class="d-flex justify-content-between align-items-center">
                    <h2 class="content-header-title my-3">
                        <span>افزودن تیکت</span>
                    </h2>
                    <section class="content-header-link">
                        <a href="{{ route('home.profile.my-ticket') }}" class="btn btn-danger text-white">بازگشت</a>
                    </section>
                </section>
            </section>
            <!-- end vontent header -->

            <form action="{{ route('home.profile.my-ticket.store') }}" method="post" enctype="multipart/form-data"
                id="form">
                @csrf
                <section class="row">

                    <section class="col-12 my-2">
                        <div class="form-group">
                            <label for="subject">موضوع تیکت</label>
                            <input type="text" class="form-control form-control-sm" name="subject" id="subject"
                                value="{{ old('subject') }}">
                        </div>
                        @error('subject')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 col-md-6 my-2">
                        <div class="form-group">
                            <label for="category_id">انتخاب دسته</label>
                            <select name="category_id" id="category_id" class="form-control form-control-sm">
                                <option value="">دسته را انتخاب کنید</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        @error('category_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 col-md-6 my-2">
                        <div class="form-group">
                            <label for="priority_id">انتخاب الویت</label>
                            <select name="priority_id" id="priority_id" class="form-control form-control-sm">
                                <option value="">دسته را انتخاب کنید</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}" @if (old('priority_id') == $priority->id) selected @endif>
                                        {{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('priority_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 my-2">
                        <div class="form-group">
                            <label for="description">متن تیکت</label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-sm">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                     <section class="col-12 my-2">
                            <div class="form-group">
                                <label for="file">فایل</label>
                                <input type="file" class="form-control form-control-sm" name="file" id="file">
                            </div>
                            @error('file')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>

                        <section class="col-12 my-2">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>

                </section>
            </form>

        </section>
    </main>
@endsection
