@extends('customer.layouts.master-two-col')
@section('head-tag')
<title>تیکت های من</title>
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
                                <h2 class="content-header-title">
                                    <span>تیکت های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="{{ route('home.profile.my-ticket.create') }}" class="btn btn-success text-white my-2">تیکت جدید</a>
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                              <section class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان تیکت</th>
                            <th>دسته تیکت</th>
                            <th>اولویت تیکت</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($tickets as $ticket)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>{{ $ticket->priority->name }}</td>
                            <td>{{ $ticket->status == 0 ? 'بسته شده' : 'باز' }}</td>
                            <td class="width-16-rem text-center">
                                <a href="{{ route('home.profile.my-ticket.show', $ticket->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> مشاهده</a>
                                @if($ticket->status == 1)
                                <a href="{{ route('home.profile.my-ticket.change', $ticket->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> بستن</a>
                                @endif
                            </td>
                        </tr>

                        @endforeach


                    </tbody>
                </table>
            </section>


                    </section>
                </main>
@endsection