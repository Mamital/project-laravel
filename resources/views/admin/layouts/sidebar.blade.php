<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">


            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>مشاهده فروشگاه</span>
            </a>
            <hr>
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>

            <section class="sidebar-part-title">بخش فروش</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>ویترین</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('read-productCategory')
                        <a href="{{ route('admin.market.category.index') }}">دسته بندی</a>
                    @endcan
                    @can('read-baner')
                        <a href="{{ route('admin.market.baner.index') }}">بنر ها</a>
                    @endcan
                    @can('read-product')
                        <a href="{{ route('admin.market.property.category.index') }}">فرم کالا</a>
                    @endcan
                    @can('read-brand')
                        <a href="{{ route('admin.market.brand.index') }}">برندها</a>
                    @endcan
                    @can('read-product')
                        <a href="{{ route('admin.market.product.index') }}">کالاها</a>
                    @endcan
                    @can('read-store')
                        <a href="{{ route('admin.market.store.index') }}">انبار</a>
                    @endcan
                    @can('read-productComment')
                        <a href="{{ route('admin.market.comment.index') }}">نظرات</a>
                    @endcan
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>سفارشات</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('read-order')
                        <a href="{{ route('admin.market.order.newOrders') }}"> جدید</a>
                        <a href="{{ route('admin.market.order.sending') }}">در حال ارسال</a>
                        <a href="{{ route('admin.market.order.unpaid') }}">پرداخت نشده</a>
                        <a href="{{ route('admin.market.order.canceled') }}">باطل شده</a>
                        <a href="{{ route('admin.market.order.returned') }}">مرجوعی</a>
                        <a href="{{ route('admin.market.order.all') }}">تمام سفارشات</a>
                    @endcan
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>پرداخت ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('read-payment')
                        <a href="{{ route('admin.market.payment.index') }}">تمام پرداخت ها</a>
                        <a href="{{ route('admin.market.payment.online') }}">پرداخت های آنلاین</a>
                        <a href="{{ route('admin.market.payment.offline') }}">پرداخت های آفلاین</a>
                        <a href="{{ route('admin.market.payment.attendance') }}">پرداخت در محل</a>
                    @endcan
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>تخفیف ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('read-discount')
                        <a href="{{ route('admin.market.discount.copan') }}">کوپن تخفیف</a>
                        <a href="{{ route('admin.market.discount.commonDiscount') }}">تخفیف عمومی</a>
                        <a href="{{ route('admin.market.discount.amazingSale') }}">فروش شگفت انگیز</a>
                    @endcan
                </section>
            </section>
            @can('read-delivery')
                <a href="{{ route('admin.market.delivery.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>روش های ارسال</span>
                </a>
            @endcan



            <section class="sidebar-part-title">بخش محتوی</section>
            @can('read-postCategory')
                <a href="{{ route('admin.content.category.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>دسته بندی</span>
                </a>
            @endcan
            @can('read-post')
                <a href="{{ route('admin.content.post.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>پست ها</span>
                </a>
            @endcan
            @can('read-postComment')
                <a href="{{ route('admin.content.comment.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>نظرات</span>
                </a>
            @endcan
            @can('read-menu')
                <a href="{{ route('admin.content.menu.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>منو</span>
                </a>
            @endcan
            @can('read-faq')
                <a href="{{ route('admin.content.faq.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>سوالات متداول</span>
                </a>
            @endcan
            @can('read-page')
                <a href="{{ route('admin.content.page.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>پیج ساز</span>
                </a>
            @endcan


            <section class="sidebar-part-title">بخش کاربران</section>
            @can('read-admin')
                <a href="{{ route('admin.user.admin-user.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>کاربران ادمین</span>
                </a>
            @endcan
            @can('read-customer')
                <a href="{{ route('admin.user.customer.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>مشتریان</span>
                </a>
            @endcan

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>سطوح دسترسی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('read-role')
                        <a href="{{ route('admin.user.role.index') }}">مدیریت نقش ها</a>
                    @endcan
                    @can('read-permission')
                        <a href="{{ route('admin.user.permission.index') }}">مدیریت دسترسی ها</a>
                    @endcan
                </section>
            </section>



            <section class="sidebar-part-title">تیکت ها</section>
            @can('read-ticketCategory')
                <a href="{{ route('admin.ticket.category.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span> دسته بندی تیکت ها </span>
                </a>
            @endcan
            @can('read-ticketPriority')
                <a href="{{ route('admin.ticket.priority.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span> اولویت تیکت ها </span>
                </a>
            @endcan
            @can('read-ticketAdmin')
                <a href="{{ route('admin.ticket.admin.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span> ادمین تیکت ها </span>
                </a>
            @endcan
            @can('read-ticket')
                <a href="{{ route('admin.ticket.newTickets') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>تیکت های جدید</span>
                </a>
                <a href="{{ route('admin.ticket.openTickets') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>تیکت های باز</span>
                </a>
                <a href="{{ route('admin.ticket.closeTickets') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>تیکت های بسته</span>
                </a>

                <a href="{{ route('admin.ticket.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>همه ی تیکت ها</span>
                </a>
            @endcan



            <section class="sidebar-part-title">اطلاع رسانی</section>
            @can('read-email')
                <a href="{{ route('admin.notify.email.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>اعلامیه ایمیلی</span>
                </a>
            @endcan
            @can('read-sms')
                <a href="{{ route('admin.notify.sms.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>اعلامیه پیامکی</span>
                </a>
            @endcan



            <section class="sidebar-part-title">تنظیمات</section>
            @can('read-setting')
                <a href="{{ route('admin.setting.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>تنظیمات</span>
                </a>
            @endcan

        </section>
    </section>
</aside>
