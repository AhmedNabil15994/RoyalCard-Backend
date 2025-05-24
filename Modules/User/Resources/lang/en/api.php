<?php

return [
    'users' => [
        'wallet'    => [
            'add_balance'   => 'Add Balance',
            'withdraw_balance'   => 'Balance Withdrawal',
            'recharge_balance'  => 'Recharge Balance',
            'cashback'      => 'CashBack',
            'order'         => 'Order',

            'add_balance_desc'   => 'A balance of :balance has been added to your wallet as a result :type The balance is valid for use in your upcoming orders.',
            'withdraw_balance_desc'   => 'A balance of :balance has been deducted from your wallet as a result of activating the use of the wallet in your previous order #:order .',
        ],
        'updated'   => 'Data has been updated successfully!!',
        'validation'    => [
            'current_password'  => [
                'required'  => 'Current password is required',
            ],
            'email'             => [
                'required'  => 'Please enter the email of user',
                'unique'    => 'This email is taken before',
            ],
            'mobile'            => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of user',
                'unique'            => 'This mobile is taken before',
            ],
            'name'              => [
                'required'  => 'Please enter the name of user',
            ],
            'captcha'              => [
                'required'  => 'Please enter captcha',
                'captcha'  => 'Please check captcha entered , try again !',
            ],
            'password'          => [
                'min'       => 'Password must be more than 8 characters',
                'required'  => 'Please enter the password of user',
                'same'      => 'The Password confirmation not matching',
            ],
        ],
    ],
];
