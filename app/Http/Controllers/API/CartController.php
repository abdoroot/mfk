<?php
// app/Http/Controllers/API/CartController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Http\Resources\API\CartItem;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $guestId = $request->input('guest_id');

            if ($user) {
                $cartItems = $this->cartService->getCartItems(null, $user->id);
            } else {
                $request->validate(['guest_id' => 'required']);
                $cartItems = $this->cartService->getCartItems($guestId);
            }

            return response()->json(CartItem::collection($cartItems));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch cart items', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|integer|max:255',
                'quantity' => 'required|integer',
            ]);

            $user = Auth::user();
            $guestId = $request->input('guest_id');

            if ($user) {
                $cart = Cart::updateOrCreate(
                    ['item_id' => $request->item_id, 'user_id' => $user->id],
                    ['quantity' => $request->quantity]
                );
            } else {
                $request->validate(['guest_id' => 'required']);
                $cart = Cart::updateOrCreate(
                    ['item_id' => $request->item_id, 'guest_id' => $guestId],
                    ['quantity' => $request->quantity]
                );
            }

            return response()->json(new CartItem($cart), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to store cart item', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(['quantity' => 'required|integer']);

            $user = Auth::user();
            $guestId = $request->input('guest_id');

            if ($user) {
                $cartItem = Cart::where('id', $id)
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            } else {
                $request->validate(['guest_id' => 'required']);
                $cartItem = Cart::where('id', $id)
                    ->where('guest_id', $guestId)
                    ->firstOrFail();
            }

            $cartItem->update(['quantity' => $request->quantity]);
            $cartItem->refresh();

            return response()->json(new CartItem($cartItem));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update cart item', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $guestId = $request->input('guest_id');

            if ($user) {
                $cartItem = Cart::where('id', $id)
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            } else {
                $request->validate(['guest_id' => 'required']);
                $cartItem = Cart::where('id', $id)
                    ->where('guest_id', $guestId)
                    ->firstOrFail();
            }

            $cartItem->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete cart item', 'error' => $e->getMessage()], 500);
        }
    }

    public function clear(Request $request)
    {
        try {
            $user = Auth::user();
            $guestId = $request->input('guest_id');

            $this->cartService->clearCart($guestId, $user ? $user->id : null);

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to clear cart', 'error' => $e->getMessage()], 500);
        }
    }
}
