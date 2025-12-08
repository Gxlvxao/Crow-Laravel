<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.access-requests') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-accent shadow-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="text-2xl font-bold text-graphite font-heading">
                        {{ __('messages.request_details', ['id' => $accessRequest->id]) }}
                    </h2>
                </div>
                
                <div class="flex items-center gap-2">
                    @if($accessRequest->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">{{ __('messages.pending') }}</span>
                    @elseif($accessRequest->status === 'approved')
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">{{ __('messages.approved') }}</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">{{ __('messages.rejected') }}</span>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative mb-6 shadow-sm flex items-start gap-3" role="alert">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong class="font-bold">{{ __('messages.success') }}!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        @if(Str::contains(session('success'), 'senha') || Str::contains(session('success'), 'password'))
                            <div class="mt-2 bg-white/50 p-2 rounded border border-green-200">
                                <p class="text-sm text-green-900 font-bold">⚠️ {{ __('messages.copy_password') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg relative mb-6 shadow-sm" role="alert">
                    <strong class="font-bold">{{ __('messages.error') }}!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-graphite font-heading">{{ __('messages.main_info') }}</h3>
                            @if($accessRequest->user)
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">{{ __('messages.existing_user') }}</span>
                            @endif
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('messages.name') }}</label>
                                <div class="text-base font-semibold text-graphite">{{ $accessRequest->name }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('messages.email') }}</label>
                                <div class="text-base text-graphite">{{ $accessRequest->email }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('messages.location') }}</label>
                                <div class="text-base text-graphite flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $accessRequest->country }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('messages.type') }}</label>
                                <div class="text-base text-graphite">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $accessRequest->investor_type === 'developer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($accessRequest->investor_type) }}
                                    </span>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('messages.investment') }}</label>
                                <div class="text-lg font-bold text-accent">{{ $accessRequest->investment_amount ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-graphite font-heading">{{ __('messages.description_label') }}</h3>
                        </div>
                        <div class="p-6">
                            @if($accessRequest->message)
                                <div class="prose max-w-none text-gray-600 bg-gray-50 p-4 rounded-lg italic border-l-4 border-accent">
                                    "{{ $accessRequest->message }}"
                                </div>
                            @else
                                <p class="text-gray-400 italic">Nenhuma mensagem.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    
                    @if($accessRequest->status === 'pending')
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-accent/20">
                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-bold text-graphite font-heading mb-4">{{ __('messages.management') }}</h3>
                            
                            <form method="POST" action="{{ route('admin.access-requests.approve', $accessRequest) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ __('messages.approve') }}
                                </button>
                            </form>

                            <div class="border-t border-gray-100 my-4"></div>

                            <button onclick="document.getElementById('rejectPanel').classList.remove('hidden')" class="w-full bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 font-semibold py-2 px-4 rounded-lg transition-colors">
                                {{ __('messages.reject') }}
                            </button>

                            <div id="rejectPanel" class="hidden mt-4 bg-red-50 p-4 rounded-lg animate-fade-in-down">
                                <form method="POST" action="{{ route('admin.access-requests.reject', $accessRequest) }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="rejection_reason" rows="2" class="w-full text-sm border-red-200 rounded-md focus:ring-red-500 focus:border-red-500 mb-2" placeholder="{{ __('messages.rejection_reason') }}"></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-red-600 text-white text-xs font-bold py-2 rounded hover:bg-red-700">{{ __('messages.confirm') }}</button>
                                        <button type="button" onclick="document.getElementById('rejectPanel').classList.add('hidden')" class="flex-1 bg-gray-200 text-gray-700 text-xs font-bold py-2 rounded hover:bg-gray-300">{{ __('messages.cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @elseif($accessRequest->status === 'approved' && $accessRequest->user)
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-gray-800 px-6 py-4 border-b border-gray-700">
                            <h3 class="text-lg font-bold text-white font-heading flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ __('messages.investor_management') }}
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            
                            <form method="POST" action="{{ route('admin.users.toggle-status', $accessRequest->user) }}">
                                @csrf @method('PATCH')
                                @if($accessRequest->user->status === 'active')
                                    <button type="submit" class="w-full bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        {{ __('messages.freeze_access') }}
                                    </button>
                                @else
                                    <button type="submit" class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                        {{ __('messages.reactivate_access') }}
                                    </button>
                                @endif
                            </form>

                            <form method="POST" action="{{ route('admin.users.reset-password', $accessRequest->user) }}" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    {{ __('messages.reset_password') }}
                                </button>
                            </form>
                            
                            <div class="border-t border-gray-100 my-2"></div>

                            <form method="POST" action="{{ route('admin.users.delete', $accessRequest->user) }}" onsubmit="return confirm('{{ __('messages.confirm_deletion_text') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    {{ __('messages.delete_client') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-graphite font-heading">Documentação</h3>
                        </div>
                        <div class="p-6">
                            @if($accessRequest->proof_document)
                                <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 text-center">
                                    @php
                                        $extension = pathinfo($accessRequest->proof_document, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                                        <img src="{{ Storage::url($accessRequest->proof_document) }}" alt="Comprovante" class="max-h-64 mx-auto rounded shadow-sm hover:scale-105 transition-transform cursor-pointer" onclick="window.open(this.src, '_blank')">
                                        <p class="text-xs text-gray-400 mt-2">Clique na imagem para ampliar</p>
                                    @elseif(strtolower($extension) === 'pdf')
                                        <div class="flex flex-col items-center justify-center py-4">
                                            <svg class="w-12 h-12 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-sm font-medium text-gray-900 mb-3">Documento PDF</span>
                                            <a href="{{ Storage::url($accessRequest->proof_document) }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium py-2 px-4 rounded transition-colors flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Visualizar PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center gap-2 text-gray-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <a href="{{ Storage::url($accessRequest->proof_document) }}" target="_blank" class="text-accent hover:underline">Download Arquivo</a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-lg p-6 text-center">
                                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <p class="text-sm text-gray-500">Nenhum documento anexado.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>