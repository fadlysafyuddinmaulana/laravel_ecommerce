# Laravel E-Commerce - AI Agent Instructions

## Project Overview

Laravel 12.x e-commerce application with dual architecture: server-side rendered admin panel (AdminLTE) and RESTful API endpoints. Focus on product/category/customer/employee management with DataTables-powered interfaces.

## Architecture Pattern

### Dual Controller Pattern

**Critical distinction**: Two controller types with different responsibilities:

-   `*WebController.php` - Server-side rendering with Blade templates, form validation, redirects
-   `*Controller.php` (no suffix) - RESTful API endpoints, JSON responses via `apiResource`

**Example**:

-   `ProductWebController` → handles `/products` routes, returns views
-   `ProductController` → handles `/api/products` routes, returns JSON

**Note**: `EmployeeController` is web-only (no dual controller pattern) - handles both web routes directly without separate `EmployeeWebController`

### File Upload Pattern

All image uploads use Laravel's `public` disk:

```php
// Store files
$path = $request->file('image')->store('products', 'public');
$data['image'] = $path; // Save relative path like "products/xyz.jpg"

// Update - preserve existing image if no new upload
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('products', 'public');
    $data['image'] = $path;
} else {
    unset($data['image']); // Don't overwrite existing
}
```

### Model Pattern

**Auto-Generated Codes**: `Employee` model has a static method for auto-code generation:

```php
public static function generateEmployeeCode()
{
    $lastEmployee = self::orderBy('employee_code', 'desc')->first();
    if (!$lastEmployee) return 'EMP001';
    
    $lastNumber = (int) substr($lastEmployee->employee_code, 3);
    $newNumber = $lastNumber + 1;
    return 'EMP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}
```

Usage in controller: `$data['employee_code'] = Employee::generateEmployeeCode();`

### Database Inconsistency

⚠️ **Known Issue**: `categories` table has migration column `category_name` but models use `name`. When modifying Category features, use `name` (model convention) not `category_name`.

## View Structure

### Layout System

All views extend `layouts.app` which includes AdminLTE 3.2.0:

```blade
@extends('layouts.app')
@section('title', 'Page Title')
@section('page-title', 'Page Heading')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Current Page</li>
@endsection
```

### DataTables Integration Pattern

Standard pattern for all index views (see `resources/views/products/index.blade.php`):

```javascript
$("#example1").DataTable({
    responsive: true,
    autoWidth: false,
    columnDefs: [
        {
            orderable: false,
            targets: [0, 6], // No/Actions columns
            searchable: false,
        },
    ],
    fnDrawCallback: function (oSettings) {
        // Auto numbering implementation
        var api = this.api();
        var startIndex = api.context[0]._iDisplayStart;
        api.column(0, { order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
    },
});
```

### Row Expansion Pattern (Employee List)

For expandable row details, store data in `data-*` attributes and toggle with JavaScript:

```blade
{{-- Store data in attributes --}}
<tr data-hire-date="{{ $employee->hire_date ? date('m/d/Y', strtotime($employee->hire_date)) : '-' }}"
    data-salary="{{ $employee->salary ? '$' . number_format($employee->salary, 0, ',', ',') : '-' }}">
    <td>{{ $employee->first_name }}</td>
    <td>
        <button class="btn btn-sm btn-info details-control">
            <i class="fa-regular fa-folder-closed"></i>
        </button>
    </td>
</tr>
```

JavaScript (in view's `@push('scripts')`):

```javascript
$('.details-control').on('click', function () {
    var tr = $(this).closest('tr');
    var hireDate = tr.data('hire-date');
    var salary = tr.data('salary');
    
    var detailRow = '<tr class="detail-row"><td colspan="7">' +
                    '<strong>Hire Date:</strong> ' + hireDate + '<br>' +
                    '<strong>Salary:</strong> ' + salary + '</td></tr>';
    
    if (tr.next().hasClass('detail-row')) {
        tr.next().remove(); // Collapse
    } else {
        tr.after(detailRow); // Expand
    }
});
```

## Development Workflow

### Quick Start

```bash
composer setup       # Install deps, copy .env, generate key, migrate, npm install + build
composer dev         # Concurrent: artisan serve + queue + pail logs + vite dev
composer test        # Run PHPUnit tests
```

### Manual Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link  # Link public/storage to storage/app/public
npm install && npm run dev
```

### Running the App

Development server: `php artisan serve` (http://localhost:8000)
Asset compilation: `npm run dev` (Vite with Tailwind CSS 4.0)

## Routing Conventions

### Web Routes (web.php)

Manual resourceful routing - explicitly define each route:

```php
Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
// ... all 6 CRUD routes explicitly defined
```

### API Routes (api.php)

Use `apiResource` with custom route names:

```php
Route::apiResource('products', ProductController::class)->names([
    'index' => 'api.products.index',
    'store' => 'api.products.store',
    // ... etc
]);
```

## Common Patterns

### Validation Rules

Standard validation for products/categories:

-   `required|string|max:255` - Required text fields
-   `nullable|integer|exists:categories,id` - Foreign keys
-   `nullable|image|mimes:jpg,jpeg,png,webp|max:2048` - Images (2MB limit)
-   `boolean` - Checkboxes (is_featured)

### Success Messages

All form submissions use flash messages:

```php
return redirect()->route('products.index')->with('success', 'Product created successfully.');
```

Display in views:

```blade
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
```

### Asset References

AdminLTE assets stored in `public/assets/`:

-   AdminLTE 3.2.0 (current) - `{{ asset('assets/AdminLTE-3.2.0/...') }}`
-   AdminLTE 4.0.0-rc4 (available but unused)

## Key Files Reference

-   **Controllers**: `app/Http/Controllers/*WebController.php` (views) vs `*Controller.php` (API)
-   **Models**: `app/Models/` - Simple Eloquent models with `$fillable` arrays
-   **Migrations**: `database/migrations/` - Note the `category_name` vs `name` inconsistency
-   **Views**: `resources/views/{products,categories,employees}/` - CRUD views
-   **Routes**: `routes/web.php` (Blade) vs `routes/api.php` (JSON)
-   **Documentation**: `PROJECT_DOCUMENTATION.md`, `PENJELASAN_DATABASE_DAN_API.md` (Indonesian)

## Tech Stack

-   **Backend**: Laravel 12.x, PHP 8.2+, Laravel Sanctum (API auth), Laravel Tinker
-   **Frontend**: Blade templates, AdminLTE 3.2.0, DataTables, Font Awesome 7.1.0
-   **Build**: Vite 7.x, Tailwind CSS 4.0, npm concurrently (dev workflow)
-   **Database**: MySQL/PostgreSQL (configured in .env)
-   **Testing**: PHPUnit 11.5.3, Faker (data generation)

## Project-Specific Patterns

### Form Delete Pattern

Delete operations require POST with `@method('DELETE')` directive:

```blade
<form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" 
            onclick="return confirm('Delete this employee?')">
        <i class="fa-solid fa-trash-can"></i>
    </button>
</form>
```

### Password Hashing

Always hash passwords before storing (see `EmployeeController@store`):

```php
use Illuminate\Support\Facades\Hash;

$data['password'] = Hash::make($data['password']);
```

### Image Display Pattern

Images stored in `storage/app/public/` are accessed via `/storage/` public symlink:

```blade
@if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="" style="max-height: 60px;">
@else
    -
@endif
```

**Important**: Run `php artisan storage:link` after fresh installation.
