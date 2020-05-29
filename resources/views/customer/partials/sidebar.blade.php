<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar ">

    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'customer.openOrders.index' || Route::currentRouteName() == 'customer.openOrders.search' || Route::currentRouteName() == 'customer.openOrders.create' || Route::currentRouteName() == 'customer.openOrders.edit' ? 'active' : '' }}" href="{{ route('customer.openOrders.index' , app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Open Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'customer.closedOrders.index' ? 'active' : '' }}" href="{{ route('customer.closedOrders.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Closed Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'customer.settings.index' ? 'active' : '' }}" href="{{ route('customer.settings.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">{{ __('Settings') }}</span>
            </a>
        </li>
    </ul>

</aside>

