<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedidos de Acesso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Solicitado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Investimento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($requests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Lógica corrigida: Mostra dados do usuário se existir, senão mostra dados do formulário --}}
                                        @if($request->user)
                                            <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                            <span class="text-xs text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Usuário Existente</span>
                                        @else
                                            <div class="text-sm font-medium text-gray-900">{{ $request->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $request->email }}</div>
                                            <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Novo Cadastro</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($request->investor_type ?? $request->requested_role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $request->investment_amount ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $request->country ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($request->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendente
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aprovado
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejeitado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($request->status === 'pending')
                                            <form method="POST" action="{{ route('admin.access-requests.approve', $request) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3" onclick="return confirm('Deseja aprovar este usuário? Se for novo, uma conta será criada.')">Aprovar</button>
                                            </form>
                                            <button onclick="openRejectModal({{ $request->id }})" class="text-red-600 hover:text-red-900">Rejeitar</button>
                                        @else
                                            <span class="text-gray-400">
                                                {{ $request->reviewer ? 'Avaliado por ' . $request->reviewer->name : 'Finalizado' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Nenhum pedido de acesso encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Rejeitar Pedido</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Motivo da rejeição (opcional)
                        </label>
                        <textarea 
                            id="rejection_reason" 
                            name="rejection_reason" 
                            rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent"
                            placeholder="Explique o motivo da rejeição..."
                        ></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            Confirmar Rejeição
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(requestId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/access-requests/${requestId}/reject`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>