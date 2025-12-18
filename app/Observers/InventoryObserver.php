<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\Product;

class InventoryObserver
{
    /**
     * Handle the Inventory "created" event.
     * Update product stock when new inventory is created.
     */
    public function created(Inventory $inventory): void
    {
        $this->updateProductStock($inventory->product_id);
    }

    /**
     * Handle the Inventory "updated" event.
     * Update product stock when inventory is updated.
     */
    public function updated(Inventory $inventory): void
    {
        $this->updateProductStock($inventory->product_id);
    }

    /**
     * Handle the Inventory "deleted" event.
     * Update product stock when inventory is deleted.
     */
    public function deleted(Inventory $inventory): void
    {
        $this->updateProductStock($inventory->product_id);
    }

    /**
     * Update the total stock for a product based on all its inventories.
     * 
     * @param int $productId
     * @return void
     */
    private function updateProductStock(int $productId): void
    {
        // Calculate total available stock from all inventories for this product
        $totalStock = Inventory::where('product_id', $productId)
            ->where('status', 'Active')
            ->sum('available');

        // Update the product's stock
        Product::where('id', $productId)->update([
            'stock' => $totalStock
        ]);
    }
}
