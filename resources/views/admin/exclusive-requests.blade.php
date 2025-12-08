<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-graphite">Solicitações de Carteira (Developers)</h2>
                    <p class="text-sm text-gray-500">Estes clientes foram pré-cadastrados por seus parceiros e aguardam liberação.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Construtora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendingClients as $client)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->developer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.exclusive-requests.approve', $client) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button class="text-green-600 hover:text-green-900 font-bold mr-2">Aprovar</button>
                                        </form>
                                        <form action="{{ route('admin.exclusive-requests.reject', $client) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900">Rejeitar</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-4 text-center">Nenhuma solicitação.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $pendingClients->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>