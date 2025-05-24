<?php

return [
    'products'    => [
        'not_found' => 'Product Not Found',
        'request_limit' => "Sorry you can't request more than :limit item",
        'invalid_account_id' => "Sorry please enter account id",
        'invalid_server'    => "Sorry Invalid Server, please choose correct server for account id entered",
        'invalid_qty'       => 'Sorry please enter Quantity'
    ],
    'cart'  => [
        'empty_cart'    => "Your cart is Empty",
        'invalid_country_id'    => "Invalid Country, please select country_id",
        'invalid_payment'   => "Online Payment not valid now",
        'success_payment'   => 'Payment completed successfully',
        'invalid_order'     => 'Invalid Order, please check again',
        'order_cancelled'   => 'Order Cancelled Successfully !!',
        'failed_payment'    => 'Failed Payment , please try again',
        'insufficient_wallet_balance'   => 'Failed Payment , Insufficient Wallet Balance',
        'max_balance_exceed'   => "Sorry you Can't recharge more than :limit for :country",
        'low_balance'   => "Sorry you Can't recharge less than :limit for :country",
        'wallet_balance_exceed'   => "Sorry your Wallet Balance must not exceed :limit for :country",
    ]
];
