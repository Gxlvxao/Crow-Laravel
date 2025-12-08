<x-app-layout>
    <div class="max-w-7xl mx-auto mb-8 py-12 px-6">
        <div class="bg-gradient-to-r from-graphite to-gray-800 rounded-2xl p-8 shadow-lg text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold leading-tight font-heading mb-2">
                        {{ __('messages.welcome_back', ['name' => Auth::user()->name]) }}
                    </h2>
                    <p class="text-gray-300 text-lg">{{ __('messages.dashboard_overview_text') }}</p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 gap-3">
                    <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('messages.new_property') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mt-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">{{ __('messages.action_needed') }}</span>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['pending_requests'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">{{ __('messages.pending_requests') }}</div>
                </div>
                <a href="{{ route('admin.access-requests') }}" class="block bg-gray-50 px-6 py-3 text-sm text-accent font-semibold hover:bg-gray-100 transition-colors">
                    {{ __('messages.view_all') }} &rarr;
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-50 rounded-lg p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-graphite mb-1">{{ $stats['published_properties'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">{{ __('messages.active_properties') }}</div>
                </div>
                <a href="{{ route('admin.properties') }}" class="block bg-gray-50 px-6 py-3 text-sm text-accent font-semibold hover:bg-gray-100 transition-colors">
                    {{ __('messages.manage_catalog') }} &rarr;
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
                    <div class="text-sm text-gray-500 font-medium">{{ __('messages.total_partners') }}</div>
                </div>
                <div class="block bg-gray-50 px-6 py-3 text-sm text-gray-400 font-medium">
                    {{ __('messages.partners_desc') }}
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
                    <div class="text-sm text-gray-500 font-medium">{{ __('messages.total_investors') }}</div>
                </div>
                <div class="block bg-gray-50 px-6 py-3 text-sm text-gray-400 font-medium">
                    {{ __('messages.investors_desc') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 h-full overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-bold text-graphite font-heading">{{ __('messages.new_access_requests') ?? 'Novos Pedidos' }}</h3>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.requester') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.type') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
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
                                        <a href="{{ route('admin.access-requests') }}" class="text-accent hover:text-accent/80 font-semibold">{{ __('messages.review') }}</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 text-sm">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                            <p class="font-medium text-gray-900">{{ __('messages.all_clear') }}</p>
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
                        <h3 class="text-lg font-bold text-graphite font-heading">{{ __('messages.last_properties') }}</h3>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse($recentProperties as $property)
                        <li>
                            <a href="{{ route('properties.show', $property) }}" class="block hover:bg-gray-50 transition-colors group">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-accent truncate transition-colors">{{ Str::limit($property->title, 25) }}</p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $property->status === 'active' ? 'Ativo' : ucfirst($property->status) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-xs text-gray-500">
                                                {{ $property->city }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-xs font-medium text-graphite sm:mt-0">
                                            {{ $property->formatted_price }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-sm text-gray-500">
                            {{ __('messages.no_properties') }}
                        </li>
                        @endforelse
                    </ul>
                    <div class="bg-gray-50 p-4 border-t border-gray-100">
                        <a href="{{ route('admin.properties') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            {{ __('messages.view_all') }}
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-graphite to-gray-800 shadow-sm rounded-xl text-white p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>
                    <h3 class="text-lg font-bold font-heading mb-2 relative z-10">{{ __('messages.system_status') }}</h3>
                    <p class="text-gray-300 text-sm mb-4 relative z-10">{{ __('messages.system_ok') }}</p>
                    <div class="text-xs text-gray-400 border-t border-gray-600 pt-3 relative z-10 flex justify-between">
                        <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                        <span>PHP v{{ PHP_VERSION }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>