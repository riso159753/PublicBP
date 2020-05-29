<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar ">

    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.openOrders.index' || Route::currentRouteName() == 'employee.openOrders.search' || Route::currentRouteName() == 'employee.openOrders.create' || Route::currentRouteName() == 'employee.openOrders.edit' ? 'active' : '' }}" href="{{ route('employee.openOrders.index' , app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Open Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.closedOrders.index' ? 'active' : '' }}" href="{{ route('employee.closedOrders.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-list"></i>
                <span class="app-menu__label">{{ __('Closed Orders') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.materials.index' ? 'active' : '' }}" href="{{ route('employee.materials.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-industry"></i>
                <span class="app-menu__label">{{ __('Materials') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.users.index' ? 'active' : '' }}" href="{{ route('employee.users.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">{{ __('Users') }}</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.settings.index' ? 'active' : '' }}" href="{{ route('employee.settings.index', app()->getLocale()) }}">
                <i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">{{ __('Settings') }}</span>
            </a>
        </li>
    </ul>

</aside>

