<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-graphite">Gestão de Imóveis</h2>
                        <a href="{{ route('properties.create') }}" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-accent/90 transition text-sm font-bold">
                            + Novo Imóvel
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                        <form method="GET" action="{{ route('admin.properties') }}" class="flex gap-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título ou cidade..." class="flex-1 rounded-lg border-gray-300 text-sm">
                            <select name="status" class="rounded-lg border-gray-300 text-sm">
                                <option value="">Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                                <option value="negotiating" {{ request('status') === 'negotiating' ? 'selected' : '' }}>Em Negociação</option>
                            </select>
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-black">Filtrar</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localização</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($properties as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold">{{ $property->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $property->type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $property->city }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold 
                                            {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:text-blue-900 mr-2">Editar</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center">Nenhum imóvel.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>