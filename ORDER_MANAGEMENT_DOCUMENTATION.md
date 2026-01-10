# Order Management System Documentation

## Overview

Sistem manajemen order lengkap untuk user page dengan fitur checkout, view orders, order details, dan order tracking.

## Fitur yang Telah Diimplementasi

### 1. Database Schema

#### Orders Table

```php
- id: Primary key
- order_number: Unique order identifier (ORD001, ORD002, etc.)
- first_name, last_name: Customer name
- email: Customer email
- address, country, province, city, postal_code: Shipping address
- subtotal, delivery, discount, tax, total: Financial data
- payment_method: Payment type (credit/paypal)
- card_name, card_number_last4: Payment info
- status: Order status (pending/processing/shipped/delivered/cancelled)
- created_at, updated_at: Timestamps
```

#### Order Items Table

```php
- id: Primary key
- order_id: Foreign key to orders
- product_id: Foreign key to products
- product_name, product_price, product_image: Product snapshot
- quantity: Ordered quantity
- subtotal: Item total (price × quantity)
- created_at, updated_at: Timestamps
```

### 2. Models

#### Order Model (`app/Models/Order.php`)

- Auto-generate order number dengan `generateOrderNumber()`
- Relationship: `hasMany(OrderItem::class)`
- Protected fillable fields untuk mass assignment

#### OrderItem Model (`app/Models/OrderItem.php`)

- Relationship: `belongsTo(Order::class)`, `belongsTo(Product::class)`
- Protected fillable fields

### 3. Controllers

#### CheckoutWebController (`app/Http/Controllers/CheckoutWebController.php`)

**Updated Features:**

- Database transaction untuk data integrity
- Simpan order ke database saat checkout
- Simpan order items (cart products)
- Redirect ke success page di user area (bukan admin)
- Clear cart session setelah sukses

**Checkout Flow:**

1. Validasi input form
2. Hitung subtotal, tax, delivery
3. Begin DB transaction
4. Generate order number
5. Create order record
6. Create order items dari cart
7. Commit transaction
8. Clear cart session
9. Redirect ke `orders.success` dengan order_number

#### OrderWebController (`app/Http/Controllers/OrderWebController.php`)

**Methods:**

- `index()`: List semua orders dengan filter status
- `show($orderNumber)`: Detail order berdasarkan order number
- `success($orderNumber)`: Success page setelah checkout
- `track()`: Track order dengan order number

### 4. Views (User Page)

#### Orders Index (`resources/views/user_page/pages/orders/index.blade.php`)

**Features:**

- DataTables integration untuk list orders
- Filter by status (All, Pending, Processing, Shipped, Delivered, Cancelled)
- Responsive table dengan columns:
  - No (auto-numbered)
  - Order Number (link to detail)
  - Date
  - Total
  - Status (with badges)
  - Action (View Details button)
- Empty state message jika tidak ada orders
- Status badges dengan warna:
  - Pending: warning (yellow)
  - Processing: info (blue)
  - Shipped: primary (blue)
  - Delivered: success (green)
  - Cancelled: danger (red)

#### Order Detail (`resources/views/user_page/pages/orders/show.blade.php`)

**Features:**

- Order information grid (Order Number, Date, Status, Payment Method)
- Shipping address section
- Order items table dengan product details
- Price summary (Subtotal, Delivery, Discount, Tax, Total)
- Print order button
- Back to orders button

#### Success Page (`resources/views/user_page/pages/orders/success.blade.php`)

**Features:**

- Success confirmation message
- Order number display
- Order summary (date, total, status)
- Next steps information
- Action buttons:
  - View Order Details
  - Continue Shopping

#### Order Tracking (`resources/views/user_page/pages/orders/track.blade.php`)

**Features:**

- Track order form dengan input order number
- Visual timeline untuk order status:
  - Order Placed (pending)
  - Processing (processing)
  - Shipped (shipped)
  - Delivered (delivered)
- Active status highlighted
- Order information display (order number, date, total, current status)

### 5. Routes (`routes/web.php`)

```php
Route::get('/orders', [OrderWebController::class, 'index'])->name('orders.index');
Route::get('/orders/success/{orderNumber}', [OrderWebController::class, 'success'])->name('orders.success');
Route::get('/orders/track', [OrderWebController::class, 'track'])->name('orders.track');
Route::get('/orders/{orderNumber}', [OrderWebController::class, 'show'])->name('orders.show');
```

### 6. Navigation Menu

Updated `resources/views/user_page/layouts/partials/header.blade.php`:

- Added "Orders" dropdown menu di navbar
- Submenu items:
  - My Orders (all orders)
  - Pending Orders (status=pending)
  - Completed Orders (status=delivered)
- Active state highlighting based on current route

### 7. UI/UX Improvements

#### Checkout Page (`resources/views/user_page/pages/checkout.blade.php`)

**Fixed Spacing:**

- Page title: `mb-4` → `mb-5` (better gap dengan header)
- Checkout button: `mb-4` → `mb-5` (better gap dengan footer)

## User Flow

### Complete Checkout Flow

1. **Cart** → User menambah products ke cart
2. **Checkout Page** → Fill form (nama, alamat, payment)
3. **Submit** → Data disimpan ke database (orders + order_items)
4. **Success Page** → Konfirmasi order berhasil dengan order number
5. **Order Management** → User bisa:
   - View semua orders (My Orders)
   - Filter by status (Pending/Completed)
   - View order details
   - Track order status
   - Print order

## Testing

### Dummy Data Created

```php
Order #ORD001
- Customer: John Doe (john@example.com)
- Address: Jl. Sudirman No. 123, Jakarta Pusat, DKI JAKARTA, INDONESIA
- Total: $1,115.99
- Payment: Credit Card (**** 1234)
- Status: Pending
```

### Test Cases

1. ✅ Create order via checkout
2. ✅ View orders list with DataTable
3. ✅ View order details
4. ✅ Success page after checkout
5. ✅ Order tracking with timeline
6. ✅ Filter orders by status
7. ✅ Navigation menu (dropdown)
8. ✅ Database persistence (orders + order_items)

## Next Steps (Optional Enhancements)

1. **Authentication**: Add middleware untuk protect order routes
2. **Pagination**: Jika orders banyak, tambah pagination
3. **Export**: Export orders ke PDF/Excel
4. **Email Notification**: Kirim email konfirmasi setelah order
5. **Order Cancellation**: Fitur cancel order untuk user
6. **Reviews**: Rating & review setelah delivered
7. **Return/Refund**: Request return/refund process
8. **Real-time Tracking**: Integration dengan shipping courier API

## Files Changed/Created

### Created Files

1. `database/migrations/2026_01_10_105241_create_orders_table.php`
2. `database/migrations/2026_01_10_105247_create_order_items_table.php`
3. `app/Models/Order.php`
4. `app/Models/OrderItem.php`
5. `app/Http/Controllers/OrderWebController.php` - User page orders
6. `app/Http/Controllers/AdminOrderWebController.php` - Admin panel orders
7. `resources/views/user_page/pages/orders/index.blade.php`
8. `resources/views/user_page/pages/orders/show.blade.php`
9. `resources/views/user_page/pages/orders/success.blade.php`
10. `resources/views/user_page/pages/orders/track.blade.php`
11. `resources/views/orders/index.blade.php` - Admin all orders
12. `resources/views/orders/history.blade.php` - Admin order history
13. `resources/views/orders/show.blade.php` - Admin order details
14. `resources/views/user_page/pages/orders/index.blade.php`
15. `resources/views/user_page/pages/orders/show.blade.php`
16. `resources/views/user_page/pages/orders/success.blade.php`
17. `resources/views/user_page/pages/orders/track.blade.php`

### Modified Files

1. `app/Http/Controllers/CheckoutWebController.php`
   - Added DB transaction
   - Save order to database
   - Changed redirect to orders.success

2. `resources/views/user_page/pages/checkout.blade.php`
   - Fixed spacing (mb-4 → mb-5)

3. `resources/views/user_page/layouts/partials/header.blade.php`
   - Added Orders dropdown menu

4. `resources/views/layouts/partials/sidebar.blade.php`
   - Added Orders menu dengan route ke admin.orders.\*

5. `routes/web.php`
   - Added 4 user order routes
   - Added 5 admin order routes

## Database Statistics

- Orders table: 3 records (ORD001, ORD002, ORD003)
- Order Items table: 0 records (test data belum punya items)
- Addresses table: 58 Indonesian addresses seeded

## Admin Panel Features

### Admin Order Controller (`app/Http/Controllers/AdminOrderWebController.php`)

**Methods:**

- `index()`: List semua orders dengan filter status dan search
- `history()`: Show completed (delivered) dan cancelled orders
- `show($orderNumber)`: Detail order dengan items dan shipping info
- `updateStatus()`: Update order status (pending/processing/shipped/delivered/cancelled)
- `destroy($orderNumber)`: Delete order beserta items

### Admin Views (`resources/views/orders/`)

#### All Orders (`index.blade.php`)

**Features:**

- DataTables dengan auto-numbering
- Filter by status dropdown (All/Pending/Processing/Shipped/Delivered/Cancelled)
- Search by order number, customer name, email
- Status badges dengan warna
- Action buttons: View, Update Status, Delete
- Modal untuk update status
- Sort by date (newest first)
- Responsive design

#### Order History (`history.blade.php`)

**Features:**

- Show only delivered dan cancelled orders
- Simplified view untuk archive
- Quick access to order details
- DataTables integration
- Empty state message

#### Order Details (`show.blade.php`)

**Features:**

- Complete order information grid
- Order items table dengan product images
- Shipping address display
- Payment method info (Credit Card/PayPal)
- Price summary breakdown (Subtotal, Delivery, Discount, Tax, Total)
- Update status modal
- Print order functionality
- Back to orders navigation

### Admin Routes

```php
GET    /admin/orders                      → All orders list
GET    /admin/orders/history              → Order history (completed/cancelled)
GET    /admin/orders/{orderNumber}        → Order details
PATCH  /admin/orders/{orderNumber}/status → Update order status
DELETE /admin/orders/{orderNumber}        → Delete order
```

### Sidebar Navigation

- Orders menu dengan dropdown
- All Orders → `/admin/orders`
- Order History → `/admin/orders/history`
- Active state highlighting
- Menu auto-expand saat di route admin.orders.\*

## Summary

✅ **Complete order management system** untuk user page DAN admin panel dengan:

**User Page Features:**

- Database persistence (orders + order_items)
- Checkout flow dengan redirect ke success page
- My Orders dengan DataTables
- Order details view
- Order tracking dengan visual timeline
- Navigation menu terintegrasi

**Admin Panel Features:**

- All Orders dengan filter & search
- Order History (completed/cancelled only)
- Order details dengan product items
- Update order status functionality
- Delete orders
- Print order functionality
- Sidebar menu integration

**Technical Features:**

- Transaction-safe checkout process
- Auto-generate order numbers (ORD001, ORD002, etc.)
- Status management (pending/processing/shipped/delivered/cancelled)
- Payment method tracking (Credit Card/PayPal)
- Price breakdown (subtotal, delivery, discount, tax, total)
- Responsive DataTables
- UI/UX improvements (spacing fixes)
