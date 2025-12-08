<div x-data="{ 
    show: !document.cookie.includes('crow_cookie_consent=true'),
    accept() {
        let date = new Date();
        date.setTime(date.getTime() + (365*24*60*60*1000));
        document.cookie = 'crow_cookie_consent=true; expires=' + date.toUTCString() + '; path=/';
        this.show = false;
    }
}"
x-show="show"
x-transition:enter="transition ease-out duration-1000"
x-transition:enter-start="opacity-0 translate-y-10"
x-transition:enter-end="opacity-100 translate-y-0"
class="fixed bottom-0 left-0 right-0 z-50 p-6 flex justify-center items-end pointer-events-none"
style="display: none;"
>
    <div class="pointer-events-auto max-w-4xl w-full bg-graphite/95 backdrop-blur-md border border-white/10 text-white rounded-2xl shadow-2xl p-8 md:flex items-center justify-between gap-8">
        
        <div class="space-y-4 flex-1">
            <h3 class="text-2xl font-heading font-bold text-accent">Bem-vindo à Crow Global</h3>
            <p class="text-gray-300 leading-relaxed">
                Para oferecer a melhor experiência de Private Equity Real Estate, utilizamos cookies. 
                Por favor, selecione seu idioma de preferência para continuar.
            </p>
            <p class="text-gray-400 text-sm italic">
                To provide the best Private Equity Real Estate experience, we use cookies. 
                Please select your preferred language to continue.
            </p>
        </div>

        <div class="flex flex-col gap-4 min-w-[200px]">
            <a href="{{ route('language.switch', 'pt') }}" @click="accept()" class="group flex items-center justify-between px-6 py-4 bg-white/5 hover:bg-accent rounded-xl border border-white/10 transition-all duration-300 cursor-pointer">
                <span class="font-bold text-lg">Português</span>
                <span class="text-2xl group-hover:scale-125 transition-transform">🇵🇹</span>
            </a>

            <a href="{{ route('language.switch', 'en') }}" @click="accept()" class="group flex items-center justify-between px-6 py-4 bg-white/5 hover:bg-accent rounded-xl border border-white/10 transition-all duration-300 cursor-pointer">
                <span class="font-bold text-lg">English</span>
                <span class="text-2xl group-hover:scale-125 transition-transform">🇬🇧</span>
            </a>
        </div>

    </div>
</div>