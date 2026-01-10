# CSS Files Structure

## Admin Plugins

- `admin/plugins/select2-custom.css` - Select2 height fix untuk AdminLTE Bootstrap 4 theme
- `admin/plugins/intl-tel-input-custom.css` - International telephone input customization

## Admin Components

- `admin/components/filter-buttons.css` - Figma-style filter buttons (primary, secondary, danger, success, visibility, featured)
- `admin/components/action-buttons.css` - Figma-style action buttons untuk view/edit/delete

## Admin Pages

- `admin/pages/products.css` - Product pages styling
- `admin/pages/positions.css` - Position pages styling
- `admin/pages/employees.css` - Employee list dengan expandable row details
- `admin/pages/customers.css` - Customer list customization (badge, detail-row)
- `admin/pages/orders.css` - Order show page print styles
- `admin/pages/departments.css` - Department pages styling

## User Pages

- `user/pages/shop.css` - Shop/product listing page
- `user/pages/checkout.css` - Checkout process page
- `user/pages/cart.css` - Shopping cart page
- `user/pages/product-detail.css` - Product detail page
- `user/pages/orders.css` - Orders dashboard (index, success, track, show)
- `user/pages/services.css` - Services page (hero, grid, CTA sections)

## User Components

- `user/components/cart-dropdown.css` - Cart dropdown di header (Tokopedia-style badge)

## Usage in Blade Files

### Basic Usage

```blade
@push('styles')
    @vite('resources/css/admin/components/filter-buttons.css')
@endpush
```

### Multiple Files

```blade
@push('styles')
    @vite([
        'resources/css/admin/plugins/select2-custom.css',
        'resources/css/admin/components/filter-buttons.css'
    ])
@endpush
```

## Notes

- All CSS files are compiled via Vite
- Inline `<style>` tags are removed from Blade files
- External CSS files are cacheable and reusable
- Google Fonts (Inter) still loaded via CDN in `@push('styles')`
