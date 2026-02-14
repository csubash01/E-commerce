<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;

class CartManagement {
    // Add item to cart
    static public function addItemToCart($product_id){
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                $existing_item = $key;
                break;
            }
        }

        if($existing_item !== null){
            $cart_items[$existing_item]['quantity']++; // Increment quantity if item already exists in cart
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount']; // Update total price
        }else{
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if($product){
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                    'image' => $product->images[0] ?? null, // Assuming images is an array and taking the first image
                ];
            }
        }
        self::addCartItemToCookie($cart_items);
        return count($cart_items);
    }

    // Remove item from cart
    static public function removeCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                unset($cart_items[$key]); // Remove item from cart
                // break;
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }

    //add cart item to cookies

    static public function addCartItemToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60*24*30); // Store cart items in cookies for 30 days
    }

    //clear cart item from cookies

    static public function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items')); // Clear cart items from cookies
    }

    //get all cart items from cookies

    static public function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        return $cart_items ? $cart_items : [];
    }

    //increment cart item quantity

    static public function incrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']++; // Increment quantity
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']; // Update total price
                break;
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }

    //decreement cart item quantity

    static public function decrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                if($cart_items[$key]['quantity'] > 1){
                    $cart_items[$key]['quantity']--; // Decrement quantity
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']; // Update total price
                }
                break;
            }
        }
        self::addCartItemToCookie($cart_items);
        return $cart_items;
    }

    //calculate total price of cart items

    static public function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_amount'));

    }
}

