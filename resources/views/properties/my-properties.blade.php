<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meus Imóveis
            </h2>
            <a href="{{ route('properties.create') }}" class="bg-accent hover:bg-accent/90 text-white font-semibold py-2 px-6 rounded-lg transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Adicionar Imóvel
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="accessManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($properties->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if($property->cover_image)
                                    <img src="{{ Storage::url($property->cover_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">Sem imagem</div>
                                @endif
                                
                                <div class="absolute top-4 left-4 flex flex-col gap-1">
                                    @if($property->status === 'active')
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Ativo</span>
                                    @elseif($property->status === 'negotiating')
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Em Negociação</span>
                                    @elseif($property->status === 'draft')
                                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Rascunho</span>
                                    @endif

                                    @if($property->is_exclusive)
                                        <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">Off-Market</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-lg font-bold text-graphite mb-1 truncate">{{ $property->title }}</h3>
                                <p class="text-gray-500 text-xs mb-4">{{ $property->city }}</p>
                                
                                <div class="flex flex-col gap-2 border-t border-gray-100 pt-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('properties.edit', $property) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 rounded text-sm text-center transition-colors">Editar</a>
                                        
                                        <button @click="openModal({{ $property->id }}, '{{ $property->title }}')" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 rounded text-sm transition-colors border border-blue-200">
                                            Gerenciar Acesso
                                        </button>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-2">
                                        <a href="{{ route('properties.show', $property) }}" class="text-xs text-gray-400 hover:text-accent">Ver como cliente</a>
                                        <button onclick="confirmDelete({{ $property->id }})" class="text-red-400 hover:text-red-600 text-xs">Excluir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">{{ $properties->links() }}</div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <p class="text-gray-500 mb-6">Nenhum imóvel cadastrado.</p>
                    <a href="{{ route('properties.create') }}" class="inline-block bg-accent hover:bg-accent/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors">
                        Adicionar Primeiro Imóvel
                    </a>
                </div>
            @endif
        </div>

        <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal()"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-xl font-bold leading-6 text-graphite mb-2">Acesso: <span x-text="currentPropertyTitle"></span></h3>
                        <p class="text-sm text-gray-500 mb-4">Selecione quais investidores podem visualizar este imóvel.</p>
                        
                        <div class="max-h-60 overflow-y-auto border rounded-lg divide-y divide-gray-100 bg-gray-50 p-2" x-show="!loading">
                            <template x-for="client in clients" :key="client.id">
                                <div class="flex items-center justify-between p-3 hover:bg-white rounded transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-xs" x-text="client.name.substring(0,1)"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900" x-text="client.name"></p>
                                            <p class="text-xs text-gray-500" x-text="client.email"></p>
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" 
                                               :checked="allowedIds.includes(client.id)" 
                                               @change="toggleAccess(client.id, $event.target.checked)">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    </label>
                                </div>
                            </template>
                            <div x-show="clients.length === 0" class="text-center py-4 text-gray-500 text-sm">
                                Nenhuma cliente na sua carteira. <a href="{{ route('developer.clients') }}" class="text-accent underline">Adicionar Clientes</a>
                            </div>
                        </div>
                        <div x-show="loading" class="py-8 text-center text-gray-500">Carregando lista...</div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" @click="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Confirmar Exclusão</h3>
                    <p class="text-sm text-gray-500 mb-4">Tem certeza que deseja excluir este imóvel?</p>
                    <form id="deleteForm" method="POST">
                        @csrf @method('DELETE')
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">Confirmar</button>
                            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function accessManager() {
            return {
                isOpen: false,
                loading: false,
                currentPropertyId: null,
                currentPropertyTitle: '',
                clients: [],
                allowedIds: [],

                openModal(propertyId, title) {
                    this.currentPropertyId = propertyId;
                    this.currentPropertyTitle = title;
                    this.isOpen = true;
                    this.loading = true;
                    
                    fetch(`/properties/${propertyId}/access-list`)
                        .then(res => res.json())
                        .then(data => {
                            this.clients = data.clients.data ? data.clients.data : data.clients; // Handle pagination wrapper if present
                            this.allowedIds = data.allowed_ids;
                            this.loading = false;
                        });
                },

                closeModal() {
                    this.isOpen = false;
                    this.clients = [];
                },

                toggleAccess(clientId, isChecked) {
                    fetch(`/properties/${this.currentPropertyId}/access`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ user_id: clientId, access: isChecked })
                    }).then(res => {
                        if(!res.ok) alert('Erro ao atualizar permissão.');
                    });
                }
            }
        }

        // Delete Modal Logic
        function confirmDelete(propertyId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/properties/${propertyId}`;
            modal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
</x-app-layout>