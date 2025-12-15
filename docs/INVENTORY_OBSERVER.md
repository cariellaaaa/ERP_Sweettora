# Inventory Observer - Auto Update Product Stock

## Overview

Observer ini secara otomatis mengupdate stock di tabel `products` berdasarkan total `available` dari semua inventory yang berstatus `Active`.

## Cara Kerja

### 1. **Event yang Dipantau**

Observer memantau 3 event pada model `Inventory`:

-   `created` - Ketika inventory baru dibuat
-   `updated` - Ketika inventory diupdate
-   `deleted` - Ketika inventory dihapus

### 2. **Proses Update Stock**

Setiap kali salah satu event di atas terjadi, observer akan:

1. Menghitung total `available` dari semua inventory dengan `status = 'Active'` untuk product tersebut
2. Update kolom `stock` di tabel `products` dengan total tersebut

### 3. **Formula Perhitungan**

```php
Product Stock = SUM(Inventory.available WHERE product_id = X AND status = 'Active')
```

## Contoh Penggunaan

### Scenario 1: Menambah Inventory Baru

```php
// Buat inventory baru
Inventory::create([
    'product_id' => 1,
    'warehouse_id' => 1,
    'quantity' => 100,
    'reserved' => 10,
    'available' => 90,  // quantity - reserved
    'status' => 'Active',
    // ... fields lainnya
]);

// Observer otomatis update Product stock = 90
```

### Scenario 2: Update Inventory

```php
$inventory = Inventory::find(1);
$inventory->update([
    'quantity' => 150,
    'available' => 140
]);

// Observer otomatis recalculate dan update Product stock
```

### Scenario 3: Multiple Inventories

```php
// Product ID 1 punya 3 inventory:
// Inventory 1: available = 90, status = 'Active'
// Inventory 2: available = 50, status = 'Active'
// Inventory 3: available = 30, status = 'Expired'

// Product stock akan = 90 + 50 = 140
// (Inventory 3 tidak dihitung karena status bukan 'Active')
```

## File Terkait

1. **Observer**: `app/Observers/InventoryObserver.php`
2. **Model**: `app/Models/Inventory.php`
3. **Model**: `app/Models/Product.php`
4. **Provider**: `app/Providers/AppServiceProvider.php`

## Testing

Untuk memastikan observer bekerja dengan baik:

```bash
# Jalankan tinker
php artisan tinker

# Test create inventory
$product = Product::find(1);
echo "Stock sebelum: " . $product->stock . "\n";

Inventory::create([
    'product_id' => 1,
    'warehouse_id' => 1,
    'quantity' => 100,
    'available' => 100,
    'status' => 'Active'
]);

$product->refresh();
echo "Stock sesudah: " . $product->stock . "\n";
```

## Notes

-   Observer hanya menghitung inventory dengan status `'Active'`
-   Inventory dengan status `'Expired'`, `'Damaged'`, atau `'Inactive'` tidak dihitung
-   Update stock terjadi secara otomatis, tidak perlu manual update
-   Jika semua inventory dihapus, stock akan menjadi 0
