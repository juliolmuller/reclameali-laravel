<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Add features to Blade Template
     *
     * @return void
     */
    public function boot()
    {
        $this->setupComponents();
        $this->setupFormattingDirectives();
    }

    /**
     * Create aliases to components
     *
     * @return void
     */
    private function setupComponents()
    {
        Blade::component('layout.header', 'header');
        Blade::component('layout.footer', 'footer');
    }

    /**
     * Define directives to format data
     *
     * @return void
     */
    private function setupFormattingDirectives()
    {
        Blade::directive('datetime', function ($expression) {
            return "<?= ($expression)->format('m/d/Y G:i') ?>";
        });
        Blade::directive('date', function ($expression) {
            return "<?= ($expression)->format('j-M-Y') ?>";
        });
        Blade::directive('time', function ($expression) {
            return "<?= ($expression)->format('G:i:s') ?>";
        });
        Blade::directive('cpf', function ($expression) {
            $pattern = '/(\d{3})(\d{3})(\d{3})(\d{2})/';
            $cpf = preg_replace($pattern, '$1.$2.$3-$4', $expression);
            return "<?= {$cpf} ?>";
        });
        Blade::directive('phone', function ($expression) {
            $pattern = '/(\d{2})(\d{4,5})(\d{4})/';
            $phone = preg_replace($pattern, '($1) $2-$3', $expression);
            return "<?= {$phone} ?>";
        });
    }
}
