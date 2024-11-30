<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Log;

class ProductObserver
    {
        public function created(Product $product)
        {
            Log::create([
                'model' => Product::class,
                'model_id' => $product->id,
                'action' => 'create',
                'changes' => $product->toArray(),
            ]);
        }
    
        public function updated(Product $product)
        {
            $changes = $product->getChanges();
            Log::create([
                'model' => Product::class,
                'model_id' => $product->id,
                'action' => 'update',
                'changes' => $changes,
            ]);
        }
    
        public function deleted(Product $product)
        {
            Log::create([
                'model' => Product::class,
                'model_id' => $product->id,
                'action' => 'delete',
                'changes' => null,
            ]);
        }
    }
    