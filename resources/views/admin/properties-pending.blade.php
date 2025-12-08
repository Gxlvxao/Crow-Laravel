<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-graphite">Imóveis Aguardando Aprovação</h2>
                <a href="{{ route('admin.properties') }}" class="text-gray-500 hover:text-accent text-sm">Ver todos os imóveis</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóvel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Developer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($properties as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                @if($property->cover_image)
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($property->cover_image) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gray-200"></div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('properties.show', $property) }}" target="_blank" class="text-sm font-bold text-accent hover:underline">
                                                    {{ Str::limit($property->title, 40) }} <span class="text-xs text-gray-400">↗</span>
                                                </a>
                                                <div class="text-xs text-gray-500">{{ ucfirst($property->type) }} • {{ $property->city }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $property->owner->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $property->owner->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        {{ $property->formatted_price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.properties.approve-listing', $property) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition-colors shadow-sm">
                                                    Publicar
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.properties.reject-listing', $property) }}" method="POST" onsubmit="return confirm('Retornar para Rascunho?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-2 px-4 rounded-lg transition-colors border border-gray-300">
                                                    Devolver
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Nenhum imóvel aguardando aprovação.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $properties->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>