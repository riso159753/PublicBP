<header class="app-header">

    <a class="app-header__logo" href="#"><img src="{{asset('images/laravel.svg')}}" width="40px"></a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>



    <ul class="app-nav">


        @foreach(config('app.available_locales') as $locale)

            @if(isset($order->id))
            <li class="dropdown">
               <a class="app-nav__item" href="{{route(\Illuminate\Support\Facades\Route::currentRouteName(),['id'=>$order->id,'locale'=>$locale])}}">{{strtoupper($locale)}}</a>
            </li>
            @else
                <li class="dropdown">
                    <a class="app-nav__item" href="{{route(\Illuminate\Support\Facades\Route::currentRouteName(),['id'=>'1','locale'=>$locale])}}">{{strtoupper($locale)}}</a>
                </li>
                @endif
    @endforeach


            <!-- User Menu-->
            <li class="dropdown">
                <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">

                    <li>
                        <a class="dropdown-item" href="{{ route('logout', app()->getLocale()) }}" ><i class="fa fa-sign-out fa-lg"></i>{{ __('Logout') }}</a>

                        <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
    </ul>
</header>


