<?php
/**
 *
 * @author Ivo Kund <ivo@opus.ee>
 * @date 4.02.14
 */

namespace opus\ecom\models;

use opus\ecom\Basket;

/**
 * All objects that can be added to the basket and that have any special effect to the basket or basket
 * price (e.g. discounts) should implement this interface
 *
 * @package opus\ecom\models
 */
interface BasketDiscountInterface extends BasketItemInterface
{
    /**
     * @param Basket $basket
     * @param integer|float $basketTotalSum
     * @return void
     */
    public function applyToBasket(Basket $basket, &$basketTotalSum);
} 