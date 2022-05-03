<?php
/**
 *
 * @author Ivo Kund <ivo@opus.ee>
 * @date 23.01.14
 */

namespace opus\ecom;

use opus\ecom\models\OrderInterface;
use opus\payment\services\payment\Transaction;

/**
 * This is the main class of the opus\ecom component that should be registered as an application component.
 *
 * @author Ivo Kund <ivo@opus.ee>
 * @package ecom
 */
class Component extends \yii\base\Component
{
    /**
     * Override to customize your basket object
     *
     * @var string|\opus\ecom\Basket
     */
    public $basket = '\opus\ecom\Basket';

    /**
     * Override to customize the formatter
     *
     * @var string|\opus\ecom\Formatter
     */
    public $formatter = '\opus\ecom\Formatter';

    /**
     * Override to to customize payment-related functionality
     *
     * @var string|\opus\ecom\Payment
     */
    public $payment = '\opus\ecom\Payment';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // initialize sub-components
        $this->formatter = \Yii::createObject($this->formatter);

        $basketConf = is_string($this->basket) ? ['class' => $this->basket] : $this->basket;
        $this->basket = \Yii::createObject($basketConf + [
            'session' => \Yii::$app->session,
            'component' => $this,
        ]);
        $paymentConf = is_string($this->payment) ? ['class' => $this->payment] : $this->payment;
        $this->payment = \Yii::createObject($paymentConf + [
            'component' => $this,
        ]);
    }

    /**
     * Override this to use custom location for payment key files. Default location is @app/config/keys/
     *
     * @param string $file
     * @return bool|string
     */
    public function createKeyFilePath($file)
    {
        return \Yii::getAlias('@app/config/keys/' . $file);
    }

    /**
     * Override this to write custom parameters to the transaction (e.g. comment) before it's sent to the bank
     *
     * @param OrderInterface $order
     * @param Transaction $transaction
     */
    public function finalizeTransaction(OrderInterface $order, Transaction $transaction)
    {
        // default behaviour does not alter transaction object
    }

    /**
     * This method can be used to generate advanced discounts (buy 3, pay for 2 etc)
     *
     * @param integer $price
     * @param Basket $basket
     * @return integer
     */
    public function finalizeBasketPrice($price, Basket $basket)
    {
        return $price;
    }
}