<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar ">

    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.openOrders.index' || Route::currentRouteName() == 'admin.openOrders.search' || Route::currentRouteName() == 'admin.openOrders.create' || Route::currentRouteName() == 'admin.openOrders.edit' ? 'active' : '' }}" href="{{ route('admin.openOrders.index' , app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Open Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.closedOrders.index' ? 'active' : '' }}" href="{{ route('admin.closedOrders.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Closed Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.users.index' || Route::currentRouteName() == 'admin.users.create' ? 'active' : '' }}" href="{{ route('admin.users.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">{{ __('Users') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.materials.index' ? 'active' : '' }}" href="{{ route('admin.materials.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-industry"></i>
                <span class="app-menu__label">{{ __('Materials') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.settings.index' ? 'active' : '' }}" href="{{ route('admin.settings.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">{{ __('Settings') }}</span>
            </a>
        </li>
    </ul>

</aside>

