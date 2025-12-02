<x-guest-layout>
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 relative">
            <img
                src="{{ asset('images/hero-luxury.jpg') }}"
                alt="Luxury Portuguese Architecture"
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-br from-graphite/90 via-graphite/70 to-graphite/90"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
                <div class="max-w-md">
                    <h1 class="font-heading text-4xl font-bold mb-4">
                        <span class="text-white">CROW</span>
                        <span class="text-accent"> GLOBAL</span>
                    </h1>
                    <p class="text-xl mb-6">Where Vision Meets Value</p>
                    <p class="text-white/80 text-lg">
                        Premium Real Estate Investments in Portugal
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 text-center">
                    <h1 class="font-heading text-3xl font-bold">
                        <span class="text-graphite">CROW</span>
                        <span class="text-accent"> GLOBAL</span>
                    </h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-graphite mb-2">Bem-vindo</h2>
                    <p class="text-muted-foreground">Acesse sua conta para continuar</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="email" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="seu@email.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-input-label for="password" :value="__('Senha')" class="text-graphite font-medium" />
                        <x-text-input 
                            id="password" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-colors pr-10"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 top-6 flex items-center px-3 text-gray-500 hover:text-graphite">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .95-3.112 3.546-5.446 6.836-6.182M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A12.05 12.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .95-3.112 3.546-5.446 6.836-6.182m4.23 1.033A12.02 12.02 0 0112 5c4.478 0 8.268 2.943 9.542 7a12.05 12.05 0 01-1.65 3.17M1 1l22 22"></path>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded border-gray-300 text-accent shadow-sm focus:ring-accent cursor-pointer" 
                                name="remember"
                            >
                            <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-accent hover:text-accent/80 font-medium transition-colors" href="{{ route('password.request') }}">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 shadow-sm">
                            Entrar
                        </button>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                Não tem uma conta?
                                <a href="{{ route('register') }}" class="text-accent hover:text-accent/80 font-medium transition-colors">
                                    Solicitar acesso
                                </a>
                            </p>
                        </div>
                    @endif
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-graphite transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Voltar para o site
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });
    </script>
</x-guest-layout>