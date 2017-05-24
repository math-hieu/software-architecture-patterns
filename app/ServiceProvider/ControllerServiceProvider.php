<?php

namespace ServiceProvider;

use Evaneos\Archi\Controllers\PokemonController;
use Evaneos\Archi\Repository\PokemonRepository;
use Evaneos\Archi\Services\PokemonService;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        $app['application.controllers.pokemon'] = function () use ($app) {
            return new PokemonController($app['db'], $app['application.services.pokemon']);
        };

        $app['application.services.pokemon'] = function() use ($app) {
            return new PokemonService($app['application.repository.pokemon']);
        };

        $app['application.repository.pokemon'] = function() use ($app) {
            return new PokemonRepository($app['db']);
        };
    }
}
