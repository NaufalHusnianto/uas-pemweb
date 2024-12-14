<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex w-1/3">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-6 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:flex">
                <x-nav-link :href="route('products', ['category[]' => 11])" :active="request()->routeIs('products') && request()->has('category') && in_array(11, request()->get('category'))">
                    {{ __('New & Featured') }}
                </x-nav-link>
                <x-nav-link :href="route('products', ['category[]' => 8])" :active="request()->routeIs('products') && request()->has('category') && in_array(8, request()->get('category'))">
                    {{ __('Man') }}
                </x-nav-link>
                <x-nav-link :href="route('products', ['category[]' => 9])" :active="request()->routeIs('products') && request()->has('category') && in_array(9, request()->get('category'))">
                    {{ __('Woman') }}
                </x-nav-link>
                <x-nav-link :href="route('products', ['category[]' => 10])" :active="request()->routeIs('products') && request()->has('category') && in_array(10, request()->get('category'))">
                    {{ __('Kids') }}
                </x-nav-link>
                <x-nav-link :href="route('products', ['category[]' => 12])" :active="request()->routeIs('products') && request()->has('category') && in_array(12, request()->get('category'))">
                    {{ __('Sale') }}
                </x-nav-link>              
            </div>

            <div class="flex items-center justify-end w-1/3">
                <!-- Search -->
                <div class="hidden sm:flex sm:items-center">
                    <input type="text" class="bg-gray-200 rounded-3xl shadow-sm border-none" placeholder="Search..." />
                </div>

                <button class="p-2 hover:bg-gray-200 rounded-full sm:ms-4">
                    <x-heroicon-o-heart class="h-5 w-5" />
                </button>
                <a href="{{ route('cart.index') }}" class="p-2 hover:bg-gray-200 rounded-full">
                    <x-heroicon-o-shopping-cart class="h-5 w-5" />
                </a>
                

                <!-- Authenticated User Menu -->
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <img 
                                        src="{{ Auth::user()->photo_url ? asset('storage/' . Auth::user()->photo_url) : '/user.png' }}" 
                                        alt="User Avatar" 
                                        class="h-10 w-10 rounded-full object-cover"
                                    />
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if (Auth::user()->role == 'admin')
                                    <x-dropdown-link :href="route('admin')">
                                        {{ __('Admin Panel') }}
                                    </x-dropdown-link>
                                @else
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                @endif

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

                <!-- Guest User Menu -->
                @guest
                    <div class="hidden sm:flex sm:items-center sm:ms-4 space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Sign In') }}</a>
                    </div>
                @endguest

                <!-- Hamburger Menu -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            @guest
                <div class="px-4 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endguest
        </div>
    </div>
</nav>
