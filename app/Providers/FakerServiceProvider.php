<?php

namespace App\Providers;

use Bezhanov\Faker\ProviderCollectionHelper;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use JansenFelipe\FakerBR\FakerBR;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create(config('app.faker_locale'));
            ProviderCollectionHelper::addAllProvidersTo($faker);
            $faker->addProvider(new FakerBR($faker));
            return $faker;
        });
    }
}
