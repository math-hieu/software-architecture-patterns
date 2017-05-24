<?php

namespace Evaneos\Archi\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Evaneos\Archi\Services\PokemonService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PokemonController
{
    /** @var Connection */
    private $connection;

    private $pokemonService;

    /**
     * PokemonController constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection, PokemonService $pokemonService)
    {
        $this->connection = $connection;
        $this->pokemonService = $pokemonService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws DBALException
     */
    public function pokedex(Request $request)
    {
        $pokemons = $this->pokemonService->list();

        return new JsonResponse([$pokemons]);
    }

    /**
     * @param string $uuid
     *
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException
     * @throws DBALException
     */
    public function getInformation($uuid)
    {
        $pokemon = $this->pokemonService->getPokemon($uuid);

        if ($pokemon === false) {
            return new JsonResponse(new \stdClass(), 404);
        }

        return new JsonResponse($pokemon);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function capture(Request $request)
    {
//        $uuid = (string) Uuid::uuid4();
        $type = $request->get('type');
        $level = (int) $request->get('level');

        if( ($uuid = $this->pokemonService->addPokemon($type, $level)) !== false){
            return new JsonResponse([
                'uuid' => $uuid,
                'type' => $type,
                'level' => $level
            ]);
        } else {
            return new JsonResponse([
                'error' => 'Pokemon already exist'
            ]);
        }

//        if( $type !== null && $level > 0 && $level <= 30) {
//            $typeSql = 'SELECT uuid, type, level FROM pokemon.collection WHERE type = :type';
//            $query = $this->connection->prepare($typeSql);
//            $query->bindValue('type', $type);
//            $query->execute();
//
//            $pokemon = $query->fetch();
//
//            if($pokemon === false) {
//                $sql = 'INSERT INTO pokemon.collection (uuid, type, level) VALUES (:uuid, :type, :level)';
//                $query = $this->connection->prepare($sql);
//                $query->bindValue('uuid', $uuid);
//                $query->bindValue('type', $type);
//                $query->bindValue('level', $level);
//                $query->execute();
//
//                return new JsonResponse([
//                    'uuid' => $uuid,
//                    'type' => $type,
//                    'level' => $level
//                ]);
//            } else {
//                return new JsonResponse([
//                    'error' => 'Pokemon already exist'
//                ]);
//            }
//        }
        // TODO check type exists
        // TODO check level is in bounds


    }

    /**
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function evolve($uuid)
    {
        // TODO

        $sql = 'SELECT * FROM pokemon.collection WHERE uuid = :uuid';
        $query = $this->connection->prepare($sql);
        $query->bindValue('uuid', $uuid);
        $query->execute();
        $pokemon = $query->fetch();

        if(!empty($pokemon)) {
            if($pokemon['type'] == 'pikachu' && ($pokemon['level'] > 0 && $pokemon['level'] <= 30)) {
                $evolve = 'raichu';
            } elseif($pokemon['type'] == 'aspicot' && ($pokemon['level'] > 0 && $pokemon['level'] <= 30)) {
                $evolve = 'coconfort';
            } else {
                return new JsonResponse(['error' => 'Type not found']);
            }

            $insert = 'UPDATE pokemon.collection SET type = :type WHERE uuid = :uuid';
            $query = $this->connection->prepare($insert);
            $query->bindValue('uuid', $uuid);
            $query->bindValue('type', $evolve);
            $query->execute();

        }

        var_dump($pokemon['type']);exit;

        return new JsonResponse([]);
    }
}
