<?php

// Dashboard ViewComposr
view()->composer([
    'category::dashboard.categories.*',
    'catalog::dashboard.products.*',
    'coupon::dashboard.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);
