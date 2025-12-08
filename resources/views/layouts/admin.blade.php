<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Portal - Crow Global</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-graphite">
    <div class="min-h-screen flex flex-col">
        
        <nav x-data="{ open: false, userMenu: false }" class="bg-graphite text-white shadow-lg sticky top-0 z-50 border-b border-accent/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="shrink-0 flex items-center gap-2">
                            <span class="font-heading font-bold text-xl tracking-wider">CROW<span class="text-accent">ADMIN</span></span>
                        </div>
                        
                        <div class="hidden md:flex md:ml-10 md:space-x-8 h-full">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                Visão Geral
                            </a>
                            <a href="{{ route('admin.access-requests') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.access-requests') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                Pedidos (Site)
                                @php
                                    $publicPending = \App\Models\AccessRequest::where('status', 'pending')->count();
                                @endphp
                                @if($publicPending > 0)
                                    <span class="ml-2 bg-yellow-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $publicPending }}</span>
                                @endif
                            </a>
                            
                            <a href="{{ route('admin.exclusive-requests') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.exclusive-requests') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                Carteiras (Devs)
                                @php
                                    $exclusivePending = \App\Models\User::whereNotNull('developer_id')->where('status', 'pending')->count();
                                @endphp
                                @if($exclusivePending > 0)
                                    <span class="ml-2 bg-blue-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-pulse">{{ $exclusivePending }}</span>
                                @endif
                            </a>

                            <a href="{{ route('admin.properties') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.properties') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                Imóveis
                            </a>
                        </div>
                    </div>

                    <div class="hidden md:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 hover:text-white focus:outline-none transition ease-in-out duration-150 gap-2">
                                <div class="text-right hidden lg:block">
                                    <div class="text-xs text-gray-400">Administrador</div>
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="h-8 w-8 rounded-full bg-accent flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>

                            <div x-show="open" 
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meu Perfil</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Sair do Sistema
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Crow Global Admin. Todos os direitos reservados.
            </div>
        </footer>
    </div>
</body>
</html>