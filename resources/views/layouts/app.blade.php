<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Crow Global') }} - Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-graphite">
    <div class="min-h-screen flex flex-col">
        
        <nav x-data="{ open: false, userMenu: false }" class="bg-graphite text-white shadow-xl sticky top-0 z-50 border-b border-accent/30 backdrop-blur-md bg-opacity-95">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center gap-2 group">
                            <div class="w-8 h-8 bg-accent rounded flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:bg-white group-hover:text-accent transition-colors">
                                C
                            </div>
                            <span class="font-heading font-bold text-xl tracking-wider group-hover:text-gray-200 transition-colors">
                                {{ __('messages.hero_title_1') }}<span class="text-accent">{{ __('messages.hero_title_2') }}</span>
                            </span>
                        </a>
                        
                        <div class="hidden md:flex md:ml-10 md:space-x-8 h-full">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    {{ __('messages.overview') }}
                                </a>
                                
                                <a href="{{ route('admin.access-requests') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.access-requests') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    {{ __('messages.requests') }}
                                    @php
                                        $pendingCount = \App\Models\AccessRequest::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="ml-2 bg-yellow-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse">{{ $pendingCount }}</span>
                                    @endif
                                </a>

                                <a href="{{ route('admin.exclusive-requests') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.exclusive-requests') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    {{ __('messages.wallets') }}
                                    @php
                                        $exclusivePending = \App\Models\User::whereNotNull('developer_id')->where('status', 'pending')->count();
                                    @endphp
                                    @if($exclusivePending > 0)
                                        <span class="ml-2 bg-blue-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse">{{ $exclusivePending }}</span>
                                    @endif
                                </a>

                                <a href="{{ route('admin.properties.pending') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.properties.pending') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    Moderação
                                    @php
                                        $pendingProperties = \App\Models\Property::where('status', 'pending_review')->count();
                                    @endphp
                                    @if($pendingProperties > 0)
                                        <span class="ml-2 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse">{{ $pendingProperties }}</span>
                                    @endif
                                </a>

                                <a href="{{ route('admin.properties') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.properties') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    {{ __('messages.properties') }}
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                    {{ __('messages.my_investments') }}
                                </a>
                                @can('manageProperties', App\Models\User::class)
                                    <a href="{{ route('properties.my') }}" 
                                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('properties.my') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                        {{ __('messages.my_properties') }}
                                    </a>
                                    <a href="{{ route('developer.clients') }}" 
                                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('developer.clients') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                        {{ __('messages.my_clients') }}
                                    </a>
                                @endcan
                            @endif
                        </div>
                    </div>

                    <div class="hidden md:flex sm:items-center sm:ml-6 gap-4">
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center gap-1 text-gray-300 hover:text-white transition-colors">
                                <span class="text-lg">{{ App::getLocale() == 'pt' ? '🇵🇹' : '🇬🇧' }}</span>
                                <span class="text-xs font-bold uppercase">{{ App::getLocale() }}</span>
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                                <a href="{{ route('language.switch', 'pt') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-between">
                                    <span>Português</span><span>🇵🇹</span>
                                </a>
                                <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-between">
                                    <span>English</span><span>🇬🇧</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm flex items-center gap-1 transition-colors" target="_blank">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            {{ __('messages.view_site') }}
                        </a>

                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-gray-700 rounded-full text-sm leading-4 font-medium text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none transition ease-in-out duration-150 gap-3 group">
                                <div class="text-right hidden lg:block">
                                    <div class="text-[10px] uppercase tracking-widest text-accent font-bold">
                                        {{ Auth::user()->role === 'admin' ? __('messages.admin_role') : (Auth::user()->role === 'developer' ? __('messages.developer_role') : __('messages.client_role')) }}
                                    </div>
                                    <div class="font-semibold leading-none">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-accent to-yellow-600 flex items-center justify-center text-white font-bold shadow-md border-2 border-transparent group-hover:border-white transition-all">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-2xl py-2 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-accent transition-colors">
                                    {{ __('messages.my_profile') }}
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden bg-gray-800 border-t border-gray-700">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-white">{{ __('messages.dashboard') }}</a>
                </div>
            </div>
        </nav>

        @if (isset($header))
            <header class="bg-white shadow border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <div class="mb-2 md:mb-0">
                    &copy; {{ date('Y') }} <span class="text-graphite font-bold">CROW GLOBAL</span>. {{ __('messages.rights_reserved') }}
                </div>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-accent">{{ __('messages.support') }}</a>
                    <a href="#" class="hover:text-accent">{{ __('messages.privacy') }}</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>