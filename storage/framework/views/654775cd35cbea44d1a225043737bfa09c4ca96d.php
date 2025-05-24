<div class="page-sidebar-wrapper">

  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item <?php echo e(active_menu('home')); ?>">
        <a href="<?php echo e(url(route('dashboard.home'))); ?>" class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title"><?php echo e(__('apps::dashboard.index.title')); ?></span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase"><?php echo e(__('apps::dashboard._layout.aside._tabs.control')); ?></h3>
      </li>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_roles')): ?>
      <li class="nav-item <?php echo e(active_menu('roles')); ?>">
        <a href="<?php echo e(url(route('dashboard.roles.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-briefcase"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.roles')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>


      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_admins')): ?>
      <li class="nav-item <?php echo e(active_menu('admins')); ?>">
        <a href="<?php echo e(url(route('dashboard.admins.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-users"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.admins')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_users')): ?>
      <li class="nav-item <?php echo e(active_menu('users')); ?>">
        <a href="<?php echo e(url(route('dashboard.users.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-users"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.users')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>
































        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['show_categories','show_products','show_servers'])): ?>
            <li class="nav-item open  <?php echo e(active_slide_menu(['categories','products','servers'])); ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title"><?php echo e(__('apps::dashboard._layout.aside.products')); ?></span>
                    <span class="arrow <?php echo e(active_slide_menu(['categories','products','servers'])); ?>"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block;">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_products')): ?>
                        <li class="nav-item <?php echo e(active_menu('products')); ?>">
                            <a href="<?php echo e(route('dashboard.products.index')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.products')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_categories')): ?>
                        <li class="nav-item <?php echo e(active_menu('categories')); ?>">
                            <a href="<?php echo e(route('dashboard.categories.index')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.categories')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_servers')): ?>
                        <li class="nav-item <?php echo e(active_menu('servers')); ?>">
                            <a href="<?php echo e(route('dashboard.servers.index')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.servers')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
            <li class="nav-item open  <?php echo e(active_slide_menu(['orders','pending_orders'])); ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title"><?php echo e(__('apps::dashboard._layout.aside._tabs.orders')); ?></span>
                    <span class="arrow <?php echo e(active_slide_menu(['orders'])); ?>"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block;">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                      <li class="nav-item <?php echo e(active_menu('active_orders')); ?>">
                          <a href="<?php echo e(route('dashboard.orders.active_orders')); ?>" class="nav-link nav-toggle">
                              <i class="fa fa-building"></i>
                              <span class="title"><?php echo e(__('apps::dashboard._layout.aside.active_orders')); ?></span>
                              <span class="selected"></span>
                          </a>
                      </li>
                  <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                      <li class="nav-item <?php echo e(active_menu('incomplete_orders')); ?>">
                          <a href="<?php echo e(route('dashboard.orders.incomplete_orders')); ?>" class="nav-link nav-toggle">
                              <i class="fa fa-building"></i>
                              <span class="title"><?php echo e(__('apps::dashboard._layout.aside.incomplete_orders')); ?></span>
                              <span class="selected"></span>
                          </a>
                      </li>
                  <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                  <li class="nav-item <?php echo e(active_menu('failed_orders')); ?>">
                      <a href="<?php echo e(route('dashboard.orders.failed_orders')); ?>" class="nav-link nav-toggle">
                          <i class="fa fa-building"></i>
                          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.failed_orders')); ?></span>
                          <span class="selected"></span>
                      </a>
                  </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                    <li class="nav-item <?php echo e(active_menu('pending_orders')); ?>">
                        <a href="<?php echo e(route('dashboard.orders.pending_orders')); ?>" class="nav-link nav-toggle">
                            <i class="fa fa-building"></i>
                            <span class="title"><?php echo e(__('apps::dashboard._layout.aside.pending_orders')); ?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
            <li class="nav-item open  <?php echo e(active_slide_menu(['reports'])); ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title"><?php echo e(__('apps::dashboard._layout.aside._tabs.reports')); ?></span>
                    <span class="arrow <?php echo e(active_slide_menu(['reports'])); ?>"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block;">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                        <li class="nav-item <?php echo e(active_menu('reports')); ?>">
                            <a href="<?php echo e(route('dashboard.reports.payments')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.payments_sales')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(active_menu('reports')); ?>">
                            <a href="<?php echo e(route('dashboard.reports.customers')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.customers_sales')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(active_menu('reports')); ?>">
                            <a href="<?php echo e(route('dashboard.reports.products')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.products_sales')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(active_menu('reports')); ?>">
                            <a href="<?php echo e(route('dashboard.wallets.transactions')); ?>" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title"><?php echo e(__('user::dashboard.users.update.form.wallets_transactions')); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>


                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_coupons')): ?>
            <li class="nav-item <?php echo e(active_menu('coupons')); ?>">
                <a href="<?php echo e(route('dashboard.coupons.index')); ?>" class="nav-link nav-toggle">
                    <i class="fa fa-building"></i>
                    <span class="title"><?php echo e(__('apps::dashboard._layout.aside.coupons')); ?></span>
                    <span class="selected"></span>
                </a>
            </li>
        <?php endif; ?>
      <li class="heading">
        <h3 class="uppercase"><?php echo e(__('apps::dashboard._layout.aside._tabs.other')); ?></h3>
      </li>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_pages')): ?>
      <li class="nav-item <?php echo e(active_menu('pages')); ?>">
        <a href="<?php echo e(url(route('dashboard.pages.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-docs"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.pages')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_sliders')): ?>
        <li class="nav-item <?php echo e(active_menu('sliders')); ?>">
            <a href="<?php echo e(url(route('dashboard.sliders.index'))); ?>" class="nav-link nav-toggle">
                <i class="icon-folder"></i>
                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.sliders')); ?></span>
                <span class="selected"></span>
            </a>
        </li>
    <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['show_countries','show_areas','show_cities','show_states'])): ?>
      <li class="nav-item  <?php echo e(active_slide_menu(['countries','cities','states','areas'])); ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.countries')); ?></span>
          <span class="arrow <?php echo e(active_slide_menu(['countries','governorates','cities','regions'])); ?>"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_countries')): ?>
          <li class="nav-item <?php echo e(active_menu('countries')); ?>">
            <a href="<?php echo e(url(route('dashboard.countries.index'))); ?>" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title"><?php echo e(__('apps::dashboard._layout.aside.countries')); ?></span>
              <span class="selected"></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_cities')): ?>
          <li class="nav-item <?php echo e(active_menu('cities')); ?>">
            <a href="<?php echo e(url(route('dashboard.cities.index'))); ?>" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title"><?php echo e(__('apps::dashboard._layout.aside.cities')); ?></span>
              <span class="selected"></span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_states')): ?>
          <li class="nav-item <?php echo e(active_menu('states')); ?>">
            <a href="<?php echo e(url(route('dashboard.states.index'))); ?>" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title"><?php echo e(__('apps::dashboard._layout.aside.state')); ?></span>
              <span class="selected"></span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </li>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_settings')): ?>
      <li class="nav-item <?php echo e(active_menu('setting')); ?>">
        <a href="<?php echo e(url(route('dashboard.setting.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.setting')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_logs')): ?>
      <li class="nav-item <?php echo e(active_menu('logs-s')); ?>">
        <a href="<?php echo e(url(route('dashboard.logs-s.index'))); ?>" class="nav-link nav-toggle">
          <i class="icon-folder"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.logs')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_telescope')): ?>
      <li class="nav-item <?php echo e(active_menu('telescope')); ?>">
        <a href="<?php echo e(url(route('telescope'))); ?>" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title"><?php echo e(__('apps::dashboard._layout.aside.telescope')); ?></span>
          <span class="selected"></span>
        </a>
      </li>
      <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_notifications')): ?>
        <li class="nav-item <?php echo e(active_menu('notifications')); ?>">
            <a href="<?php echo e(url(route('dashboard.notifications.index'))); ?>" class="nav-link nav-toggle">
                 <i class="icon-settings"></i>
                <span class="title"><?php echo e(__('apps::dashboard._layout.aside.notifications')); ?></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
  </div>

</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Apps/Resources/views/dashboard/layouts/_aside.blade.php ENDPATH**/ ?>