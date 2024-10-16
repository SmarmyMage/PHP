<?php

function priceCalc($price, $quantity) {
    $discount = [0, 0, 0.05, 0.1, 0.2, 0.25];
    $quantity = $discount[$i];
    if ($quantity > 5) {
        $discount = $discount[5];
    }
    $discountPrice = $price - ($price * $discount);
    $totalPrice = $discountPrice * $quantity;

    return $totalPrice;
}

?>