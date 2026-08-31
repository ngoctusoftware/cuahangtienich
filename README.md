# He thong Quan ly Ban hang (Laravel 11 + PHP 8.3)

Project nay chua toan bo **code ung dung** (models, controllers, migrations,
routes, views) cho he thong quan ly ban hang gom 5 module:

1. Quan ly nguoi dung (`app/Http/Controllers/Admin/UserController.php`)
2. Quan ly phan quyen - Role/Permission (`RoleController.php`)
3. Quan ly san pham + danh muc (`ProductController.php`, `CategoryController.php`)
4. Quan ly don hang (`OrderController.php`)
5. Quan ly thanh toan (`PaymentController.php` + `app/Services/Payment/*`)

Va 2 giao dien:
- **Website ban hang** (`/`, `/san-pham`, `/gio-hang`, `/thanh-toan`...): khach
  xem san pham, them gio hang, dat hang, thanh toan online (VNPay/demo) hoac COD.
- **Trang Admin** (`/admin`): quan tri toan bo du lieu, phan quyen theo vai tro.

> Luu y: day la phan **source code ung dung** (khong bao gom bo khung Laravel
> va thu vien vendor, vi moi truong tao file nay khong the tai Composer
> package tu Packagist). Ban can tao 1 project Laravel trong moi va copy
> code nay vao theo huong dan ben duoi.

## Cai dat (tren may co PHP 8.3 + Composer + MySQL)

```bash
# 1. Tao moi project Laravel 11
composer create-project laravel/laravel sales-management "11.*"
cd sales-management

# 2. Giai nen/copy toan bo thu muc trong file zip nay de vao project,
#    de ghi de len cac file/thu muc tuong ung:
#    - app/            -> app/
#    - bootstrap/app.php -> bootstrap/app.php (ghi de)
#    - config/services.php -> config/services.php (ghi de hoac merge)
#    - database/migrations -> database/migrations (xoa migration mac dinh trung ten neu co)
#    - database/seeders    -> database/seeders
#    - resources/views     -> resources/views (ghi de welcome.blade.php neu can)
#    - routes/web.php      -> routes/web.php (ghi de)
#    - routes/console.php  -> routes/console.php (ghi de)
#    - .env.example        -> tham khao de dien vao .env

# 3. Cai dat bien moi truong
cp .env.example .env    # hoac dien thu cong vao .env da co san
php artisan key:generate

# 4. Cau hinh CSDL trong .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD...)

# 5. Chay migration + seed du lieu mau (role, permission, tai khoan admin, san pham mau)
php artisan migrate --seed

# 6. Tao symlink cho storage (de hien anh san pham upload len)
php artisan storage:link

# 7. Chay thu
php artisan serve
```

Truy cap:
- Website ban hang: http://localhost:8000
- Trang quan tri: http://localhost:8000/admin

## Tai khoan quan tri mac dinh (sau khi seed)

```
Email:    admin@shop.test
Mat khau: password
```

**Hay doi mat khau nay ngay sau khi trien khai that.**

## Phan quyen (Role & Permission)

- 3 vai tro mac dinh: `admin` (toan quyen), `staff` (quan ly san pham/don
  hang/thanh toan), `customer` (khach mua hang).
- 5 permission: `users.manage`, `roles.manage`, `products.manage`,
  `orders.manage`, `payments.manage`.
- Vao **Admin > Phan quyen** de tao them vai tro va tuy chinh quyen han.
- Middleware `permission:<slug>` da duoc gan san trong `routes/web.php`.

## Thanh toan tu dong

- **COD**: mac dinh, khong can cong thanh toan.
- **VNPay**: da viet san `app/Services/Payment/VnpayService.php` theo chuan
  API VNPay (sandbox). Chi can dang ky tai khoan merchant sandbox tai
  https://sandbox.vnpayment.vn va dien `VNPAY_TMN_CODE`, `VNPAY_HASH_SECRET`
  vao `.env` la chay duoc that.
- **Cong Demo**: khi chua co tai khoan VNPay that, he thong tu dong dung
  `DemoGatewayService` (trang `/payment/demo/{code}`) de ban co the test toan
  bo luong dat hang -> thanh toan -> cap nhat trang thai don hang tu dong ma
  khong can tich hop gi them. Muon tich hop Momo/bank that, tao them 1 class
  implement `PaymentGatewayInterface` tuong tu `VnpayService`.

## Cau truc thu muc chinh

```
app/
  Models/                Role, Permission, User, Category, Product, ProductImage,
                          Order, OrderItem, Payment
  Http/Controllers/
    Admin/                Quan tri: Dashboard, User, Role, Category, Product, Order, Payment
    Shop/                 Website: Home, Product, Cart, Checkout, Order, Payment
    Auth/                 Dang ky/dang nhap khach hang
  Http/Middleware/
    EnsureUserIsAdmin.php  Chan khu vuc /admin
    CheckPermission.php    Kiem tra permission theo route
  Services/Payment/
    PaymentGatewayInterface.php
    VnpayService.php
    DemoGatewayService.php
database/
  migrations/             6 file migrate du lieu
  seeders/                Seed role/permission, tai khoan admin, du lieu mau
resources/views/
  admin/                  Giao dien quan tri (Bootstrap 5)
  shop/                   Giao dien website ban hang (Bootstrap 5)
  auth/                   Dang nhap/dang ky
routes/web.php            Toan bo route website + admin
```

## Ghi chu / Buoc mo rong tiep theo

- Co the them: danh gia san pham, ma giam gia/voucher, quan ly kho theo bien
  the (size/mau), bao cao thong ke doanh thu chi tiet hon, gui email xac nhan
  don hang (Laravel Notification), REST API cho mobile app.
- Nen chay `php artisan pint` de chuan hoa code style va viet Feature Test
  (`php artisan make:test`) cho cac luong quan trong: dat hang, thanh toan,
  phan quyen truy cap admin.
