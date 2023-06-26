<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsNames = [
            'productCategory' => 'دسته بندیه محصولات',
            'baner' => 'بنر ها',
            'brand' => 'برند ها',
            'product' => 'محصولات',
            'discount' => 'تخفیف ها',
            'delivery' => 'حمل و نقلات',
            'postCategory' => 'دسته بندی پست ها',
            'post' => 'پست ها',
            'menu' => 'منو ها',
            'faq' => 'پرسش و پاسخ',
            'page' => 'صفحه ها',
            'email' => 'ایمیل ها',
            'sms' => 'پیامک ها',
            'customer' => 'مشتری ها',
            'permission' => 'دسترسی ها',
            'ticketCategory' => 'دسته بندی تیکت ها',
            'ticketPriority' => 'اولویت تیکت ها',
            'ticketAdmin' => 'ادمین تیکت ها',

        ];

        $diffrent = [
            'read-payment' => 'مشاهده پرداخت ها',
            'edit-payment' => 'تغییر پرداخت ها',
            'read-order' => 'مشاهده سفارشات',
            'edit-order' => 'تغییر سفارشات',
            'read-productComment' => 'مشاهده نظرات محصولات',
            'approve-productComment' => 'تایید نظرات محصولات',
            'answer-productComment' => 'پاسخ به نظرات محصولات',
            'read-postComment' => 'مشاهده نظرات پست ها',
            'approve-postComment' => 'تایید نظرات پست ها',
            'answer-postComment' => 'پاسخ به نظرات پست ها',
            "create-admin" => 'ایجاد ادمین',
            "read-admin" => 'مشاهده ادمین ها',
            "edit-admin" => 'تغییر ادمین ها',
            "delete-admin" => 'حذف ادمین ها',
            "access-admin" => 'دسترسی ادمین ها',
            "create-role" => 'ساخت نقش',
            "read-role" => 'مشاهده نقش ها',
            "edit-role" => 'تغییر نقش ها',
            "delete-role" => 'حذف نقش ها',
            "access-role" => 'دسترسی نقش ها',
            'read-ticket' => 'مشاهده تیکت ها',
            'answer-tiket' => 'پاسخ به تیکت ها',
            'edit-ticket' => 'تغییر تیکت ها',
            'read-setting' => 'مشاهده تنظیمات سایت',
            'edit-setting' => 'تغییر تنظیمات سایت',
            'read-store' => 'مشاهده انبار',
            'edit-store' => 'تغییرات انبار',
        ];

        $permissions = [];
        $superAdmin = Role::create([
            'name' => 'super-admin',
            'description' => 'سوپر ادمین'
        ]);

        foreach ($permissionsNames as $permissionsName => $description) {
            $per = [
                "create-{$permissionsName}" => "ایجاد {$description}",
                "read-{$permissionsName}" => "مشاهده {$description}",
                "edit-{$permissionsName}" => "تغییر {$description}",
                "delete-{$permissionsName}" => "حذف {$description}",
            ];

            $permissions = array_merge($permissions, $per);
        }

        $permissions = array_merge($diffrent, $permissions);

        foreach ($permissions as $permission => $description) {
            $permission = Permission::create(['name' => $permission, 'status' => 1, 'description' => $description]);
            $superAdmin->permissions()->attach($permission->id);
        }
        
    }
}
