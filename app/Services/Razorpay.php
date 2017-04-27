<?php
/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 26/4/17
 * Time: 2:26 PM
 */

namespace Scalex\Zero\Services;


use Razorpay\Api\Api;

class Razorpay
{
    protected $api;

    /**
     * Razorpay constructor.
     * @param $api
     */
    public function __construct()
    {
        $key = env('API_KEY', '');
        $secret = env('API_SECRET', '');
        $this->api = new Api($key, $secret);
    }

    public function capture($paymentId, $amount)
    {
        return $this->api->payment->fetch($paymentId)->capture(['amount' => $amount]);
    }




}