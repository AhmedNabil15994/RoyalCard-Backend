<?php

view()->composer([
    'area::dashboard.cities.*',
    'area::dashboard.states.*',
    'catalog::dashboard.products.*',
    'coupon::dashboard.*',
//    'catalog::dashboard.products.edit',
//    'catalog::dashboard.products.create',
    'order::dashboard.*',
    'setting::dashboard.*',
    'category::dashboard.categories.cashback',
    'user::dashboard.users.wallets.transactions',
    'apps::dashboard.*',
], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);
