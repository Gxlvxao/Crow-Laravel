<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-graphite leading-tight font-heading">
            {{ Auth::user()->role === 'developer' ? __('messages.developer_portal') : __('messages.client_portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-br from-graphite to-gray-800 rounded-2xl p-8 shadow-xl text-white mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold font-heading mb-2">{{ __('messages.welcome_back', ['name' => Auth::user()->name]) }}</h3>
                    <p class="text-gray-300">
                        @if(Auth::user()->role === 'developer')
                            {{ __('messages.developer_overview_text') }}
                        @else
                            {{ __('messages.client_overview_text') }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="font-bold text-graphite text-lg">{{ __('messages.my_profile') }}</h4>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-accent font-medium text-sm hover:underline">{{ __('messages.manage') }} &rarr;</a>
                </div>

                @if(Auth::user()->role === 'developer')
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-green-50 rounded-lg text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <h4 class="font-bold text-graphite text-lg">{{ __('messages.my_properties') }}</h4>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('properties.my') }}" class="text-accent font-medium text-sm hover:underline">{{ __('messages.view_all') }}</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('properties.create') }}" class="text-accent font-medium text-sm hover:underline">{{ __('messages.add_property') }}</a>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-accent/10 rounded-lg text-accent">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="font-bold text-graphite text-lg">{{ __('messages.explore_properties') }}</h4>
                        </div>
                        <a href="{{ route('properties.index') }}" class="text-accent font-medium text-sm hover:underline">{{ __('messages.view_all') }} &rarr;</a>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h4 class="font-bold text-graphite text-lg">{{ __('messages.support') }}</h4>
                    </div>
                    <button class="text-accent font-medium text-sm hover:underline cursor-not-allowed opacity-50">{{ __('messages.support') }} (VIP)</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>