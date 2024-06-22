<?php
namespace App\Services;

use App\Models\Cart;

class CartService
{
    public function getCartItems($guestId = null, $userId = null)
    {
        try {
            if ($userId) {
                $cartItems = Cart::where('user_id', $userId)->get();
            } elseif ($guestId) {
                $cartItems = Cart::where('guest_id', $guestId)->get();
            } else {
                throw new \InvalidArgumentException('Either guestId or userId must be provided.');
            }

            return $cartItems;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get cart items: ' . $e->getMessage());
        }
    }

    public function clearCart($guestId = null, $userId = null)
    {
        try {
            if ($userId) {
                $cartQuery = Cart::where('user_id', $userId);
            } elseif ($guestId) {
                $cartQuery = Cart::where('guest_id', $guestId);
            } else {
                throw new \InvalidArgumentException('Either guestId or userId must be provided.');
            }

            if ($cartQuery->exists()) {
                $cartQuery->delete();
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to clear cart: ' . $e->getMessage());
        }
    }
}
