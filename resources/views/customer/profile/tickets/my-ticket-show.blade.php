@extends('customer.layouts.master-two-col')
@section('head-tag')
    <title>مشاهده تیکت</title>
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
                        <span>مشاهده تیکت</span>
                    </h2>
                    <section class="content-header-link">
                        <a href="{{route('home.profile.my-ticket')}}" class="btn btn-danger text-white">بازگشت</a>
                    </section>
                </section>
            </section>
            <!-- end vontent header -->

            <section class="card mb-3">
                <section class="card-header text-white bg-info">
                    {{ $ticket->user->full_name }}
                </section>
                <section class="card-body">
                    <h5 class="card-title">موضوع : {{ $ticket->subject }}
                    </h5>
                    <p class="card-text">
                        {{ $ticket->description }}
                    </p>
                    <a class="btn btn-info" href="{{ route('home.profile.my-ticket.download', $ticket) }}">دانلود ضمیمه</a>
                </section>
            </section>

            <hr>

            <div class="border border-light">

            @foreach ($ticket->children as $child)
                
            <section class="card m-3">
                <section class="card-header text-white bg-secondary d-flex justify-content-between">
                    <div>{{ $child->user->full_name }}</div>
                    <div>{{ jalaliDate($child->created_at) }}</div>
                </section>
                <section class="card-body">                
                    <p class="card-text">
                        {{ $child->description }}
                    </p>
                </section>
            </section>

            @endforeach

            </div>

            @if($ticket->status == 1)

            <section>
                <form action="{{ route('home.profile.my-ticket.answer', $ticket->id) }}" method="post">
                    @csrf
                    <section class="row">
                        <section class="col-12 my-2">
                            <div class="form-group">
                                <label for="">پاسخ تیکت </label>
                                ‍
                                <textarea class="form-control form-control-sm" rows="4" name="description">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm my-2">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

            @endif


        </section>
    </main>
@endsection
