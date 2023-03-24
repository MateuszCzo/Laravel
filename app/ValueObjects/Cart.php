<?php

namespace App\ValueObjects;

use Illuminate\Support\Collection;
use App\Models\Product;
use Closure;

class Cart
{
    private Collection|null $items;

    public function __construct(Collection $items = null) {
        $this->items = $items ?? Collection::empty();
    }

    public function getItems(): Collection {
        return $this->items;
    }

    public function getSum(): float {
        return $this->items->sum(function($item) {
            return $item->getSum();
        });
    }

    public function addItem(Product $product): Cart {
        $items = $this->items;
        $item = $items->first($this->isProductIdSameAsItemProduct($product));
        if(!is_null($item)) {
            $items = $this->removeItemFromCollection($items, $product);
            $newItem = $item->addQuantity($product);
        } else {
            $newItem = new CartItem($product);
        }
        $items->add($newItem);
        return new Cart($items);
    }

    public function removeItem(Product $product): Cart {
        return new Cart($this->removeItemFromCollection($this->items, $product));
    }

    private function removeItemFromCollection(Collection $items, Product $product): Collection {
        return $items->reject($this->isProductIdSameAsItemProduct($product));
    }

    private function isProductIdSameAsItemProduct(Product $product): Closure {
        return function($item) use ($product) {
            return $product->id == $item->getProductId();
        };
    }
}