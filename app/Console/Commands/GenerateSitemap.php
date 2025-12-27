<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * O nome que você vai rodar no terminal.
     */
    protected $signature = 'sitemap:generate';

    /**
     * A descrição do comando.
     */
    protected $description = 'Gera o sitemap.xml do site automaticamente';

    /**
     * Executa a lógica.
     */
    public function handle()
    {
        // Modifique a URL para a sua real
        SitemapGenerator::create('https://crowglobalinvestiments.pt')
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap gerado com sucesso!');
    }
}