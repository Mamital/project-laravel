@extends('admin.layouts.master')

@section('head-tag')
    <title>دسترسی ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی ادمین</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.admin-user.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.admin-user.permission.store', $user) }}" method="POST">
                        @csrf
                        <section class="row">

                            <section class="col-12 my-2">
                                <div class="form-group">
                                    <label for="tags">دسترسی ها</label>
                                    <select class="form-control form-control-sm" id="select-permissions" multiple name="permissions[]">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"
                                                @foreach ($user->permissions as $user_permission)
                                            @if ($user_permission->id == $permission->id)
                                            selected
                                            @endif @endforeach>
                                                {{ $permission->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('permission')
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
@section('script')
    <script>
        var permission = $('#select-permissions');
        permission.select2({
            placeholder: 'نقش های مورد نظر را انتخاب کنید',
            multiple: true,
            tags: true
        });
    </script>
@endsection
