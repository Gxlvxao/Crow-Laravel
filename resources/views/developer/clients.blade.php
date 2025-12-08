<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-graphite leading-tight font-heading">
            Minha Carteira de Investidores
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        showCreateModal: false, 
        showManageModal: false, 
        selectedClient: null,
        openManage(client) {
            this.selectedClient = client;
            this.showManageModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-500">Gerencie o acesso dos seus investidores privados aos imóveis exclusivos.</p>
                <button @click="showCreateModal = true" class="bg-accent hover:bg-accent/90 text-white font-bold py-2 px-6 rounded-lg transition-colors flex items-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Novo Investidor
                </button>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative mb-6 shadow-sm">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    @if(Str::contains(session('success'), 'Senha'))
                        <div class="mt-2 p-2 bg-white/60 rounded border border-green-200 inline-block">
                            <span class="text-xs font-bold uppercase tracking-wider text-green-800">Copie a senha e envie ao cliente</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Investidor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Cadastro</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Gestão</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($clients as $client)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-graphite text-white flex items-center justify-center font-bold shadow-sm">
                                                {{ substr($client->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $client->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($client->status === 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">Ativo</span>
                                        @elseif($client->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Aguardando Admin</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">Congelado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $client->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openManage({{ $client }})" class="text-accent hover:text-accent/80 font-bold border border-accent/30 rounded px-3 py-1 hover:bg-accent/10 transition-colors">
                                            Gerenciar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <p>Sua carteira está vazia.</p>
                                            <button @click="showCreateModal = true" class="text-accent font-bold mt-2 hover:underline">Cadastrar primeiro cliente</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-4 border-t border-gray-100">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>

        <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showCreateModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-md">
                    <div class="bg-white p-6">
                        <h3 class="text-xl font-bold text-graphite mb-2">Novo Investidor</h3>
                        <p class="text-sm text-gray-500 mb-6">O cadastro ficará como <strong>Pendente</strong> até que a administração da Crow Global aprove a entrada.</p>
                        
                        <form method="POST" action="{{ route('developer.clients.store') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
                                    <input type="text" name="name" required class="mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent" placeholder="Ex: Marcos Silva">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" required class="mt-1 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent" placeholder="cliente@email.com">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">Cancelar</button>
                                <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent/90 text-white font-bold rounded-lg transition-colors shadow-md">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showManageModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showManageModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">
                    <template x-if="selectedClient">
                        <div class="bg-white p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-graphite">Gestão de Investidor</h3>
                                <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded" x-text="'ID: ' + selectedClient.id"></span>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-xl mb-6 border border-gray-100">
                                <div class="mb-3">
                                    <label class="text-xs text-gray-500 uppercase font-bold">Nome</label>
                                    <p class="text-graphite font-medium" x-text="selectedClient.name"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-xs text-gray-500 uppercase font-bold">Email</label>
                                    <p class="text-graphite font-medium" x-text="selectedClient.email"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-bold">Status Atual</label>
                                    <p class="font-bold" :class="{
                                        'text-green-600': selectedClient.status === 'active',
                                        'text-yellow-600': selectedClient.status === 'pending',
                                        'text-red-600': selectedClient.status === 'inactive'
                                    }" x-text="selectedClient.status === 'active' ? 'Ativo' : (selectedClient.status === 'pending' ? 'Pendente' : 'Congelado')"></p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <template x-if="selectedClient.status !== 'pending'">
                                    <form :action="`/my-clients/${selectedClient.id}/toggle`" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full py-3 rounded-lg font-bold border transition-colors flex items-center justify-center gap-2"
                                            :class="selectedClient.status === 'active' 
                                                ? 'border-yellow-200 bg-yellow-50 text-yellow-700 hover:bg-yellow-100' 
                                                : 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100'">
                                            <span x-text="selectedClient.status === 'active' ? 'Congelar Acesso' : 'Reativar Acesso'"></span>
                                        </button>
                                    </form>
                                </template>

                                <form :action="`/my-clients/${selectedClient.id}`" method="POST" onsubmit="return confirm('Tem certeza absoluta? O cliente perderá acesso a todos os imóveis.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-3 rounded-lg font-bold border border-red-100 bg-white text-red-600 hover:bg-red-50 transition-colors">
                                        Excluir Cadastro
                                    </button>
                                </form>
                            </div>

                            <div class="mt-6 text-center">
                                <button @click="showManageModal = false" class="text-gray-400 hover:text-gray-600 text-sm">Fechar</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>