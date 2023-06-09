<?php

namespace Foo;

class ShopController extends Controller
{
    public function addToCart()
    {
        $cart = $_SESSION['cart_id'];
        $itemId = $_POST['item_id'];
        $amount = $_POST['amount'];

        Db::query("INSERT INTO cart_lines (cart_id, item_id, amount) VALUES ($cart, $itemId, $amount)");
    }
}