@extends('admin.layouts.master')

@section('head-tag')
    <title>نقش ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نقش ادمین</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.admin-user.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.admin-user.role.store', $user) }}" method="POST">
                        @csrf
                        <section class="row">

                            <section class="col-12 my-2">
                                <div class="form-group">
                                    <label for="tags">نقش ها</label>
                                    <select class="form-control form-control-sm" id="select-roles" multiple name="roles[]">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @foreach ($user->roles as $user_role)
                                            @if ($user_role->id == $role->id)
                                            selected
                                            @endif @endforeach>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
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
        var role = $('#select-roles');
        role.select2({
            placeholder: 'نقش های مورد نظر را انتخاب کنید',
            multiple: true,
            tags: true
        });
    </script>
@endsection
