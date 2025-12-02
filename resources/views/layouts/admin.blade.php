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
                                Pedidos de Acesso
                                @if(\App\Models\AccessRequest::where('status', 'pending')->count() > 0)
                                    <span class="ml-2 bg-accent text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ \App\Models\AccessRequest::where('status', 'pending')->count() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.properties') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('admin.properties') ? 'border-accent text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-500' }}">
                                Imóveis
                            </a>
                            <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-300 hover:text-white hover:border-gray-500 transition-colors duration-150">
                                Relatórios
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
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
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

                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
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
                    <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'border-accent text-white bg-gray-900' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        Visão Geral
                    </a>
                    <a href="{{ route('admin.access-requests') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.access-requests') ? 'border-accent text-white bg-gray-900' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        Pedidos de Acesso
                    </a>
                    <a href="{{ route('admin.properties') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.properties') ? 'border-accent text-white bg-gray-900' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        Imóveis
                    </a>
                </div>
                <div class="pt-4 pb-1 border-t border-gray-700">
                    <div class="px-4">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 transition duration-150 ease-in-out">
                                Sair
                            </button>
                        </form>
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