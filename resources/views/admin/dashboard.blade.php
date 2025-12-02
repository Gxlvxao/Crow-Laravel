<x-app-layout>
    <div class="max-w-7xl mx-auto mb-8">
        <div class="bg-gradient-to-r from-graphite to-gray-800 rounded-2xl p-8 shadow-lg text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold leading-tight font-heading mb-2">
                        Bem-vindo de volta, {{ Auth::user()->name }}
                    </h2>
                    <p class="text-gray-300 text-lg">
                        Aqui está o panorama geral da operação hoje.
                    </p>
                </div>
                <div class="mt-6 md:mt-0 flex gap-3">
                    <a href="{{ route('properties.create') }}" class="inline-flex items-center px-5 py-3 bg-accent hover:bg-accent/90 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Novo Imóvel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Ação Necessária</span>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['pending_requests'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Pedidos Pendentes</div>
                </div>
                <a href="{{ route('admin.access-requests') }}" class="block bg-gray-50 px-6 py-3 text-sm text-accent font-semibold hover:bg-gray-100 transition-colors">
                    Ver detalhes &rarr;
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">Ativos</span>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['published_properties'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Imóveis no Site</div>
                </div>
                <a href="{{ route('admin.properties') }}" class="block bg-gray-50 px-6 py-3 text-sm text-accent font-semibold hover:bg-gray-100 transition-colors">
                    Gerenciar catálogo &rarr;
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['developers'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Parceiros (Devs)</div>
                </div>
                <div class="block bg-gray-50 px-6 py-3 text-sm text-gray-400 font-medium">
                    Rede de parceiros
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['clients'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Investidores</div>
                </div>
                <div class="block bg-gray-50 px-6 py-3 text-sm text-gray-400 font-medium">
                    Carteira ativa
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 h-full overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-bold text-graphite font-heading">Novos Pedidos de Acesso</h3>
                        @if($stats['pending_requests'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 animate-pulse">
                                {{ $stats['pending_requests'] }} novos
                            </span>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($recentRequests as $request)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $request->user ? $request->user->name : $request->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $request->user ? $request->user->email : $request->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $request->investor_type === 'developer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($request->investor_type ?? $request->requested_role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.access-requests') }}" class="text-accent hover:text-accent/80 font-semibold">Avaliar</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 text-sm">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <p class="font-medium text-gray-900">Tudo em dia!</p>
                                            <p class="text-gray-500">Nenhum pedido pendente no momento.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-graphite font-heading">Últimos Imóveis</h3>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse($recentProperties as $property)
                        <li>
                            <a href="{{ route('properties.show', $property) }}" class="block hover:bg-gray-50 transition-colors group">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-accent truncate transition-colors">{{ Str::limit($property->title, 25) }}</p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $property->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $property->status === 'published' ? 'Ativo' : 'Rascunho' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-xs text-gray-500">
                                                <svg class="mr-1 h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $property->city }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-xs font-medium text-graphite sm:mt-0">
                                            € {{ number_format($property->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-sm text-gray-500">
                            Nenhum imóvel cadastrado.
                        </li>
                        @endforelse
                    </ul>
                    <div class="bg-gray-50 p-4 border-t border-gray-100">
                        <a href="{{ route('admin.properties') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Ver todos os imóveis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>