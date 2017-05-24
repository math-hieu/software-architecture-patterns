<?php

namespace Evaneos\Archi\Services;

use Doctrine\DBAL\Connection;
use Evaneos\Archi\Repository\PokemonRepository;

class PokemonService {

    private $repository;

    public function __construct(PokemonRepository $repository) {
        $this->repository = $repository;
    }

    public function list() {
        return $this->repository->findAll();
    }

    public function getPokemon($uuid) {
        return $this->repository->findByUuid($uuid);
    }

    public function getType($type) {
        return $this->repository->findByType($type);
    }

    private function exist($type) {
        return false;
    }
    public function capture($type, $level) {
        if(!$this->exist($type) && $level > 0 && $level <= 30) {
            $this->repository->insert($type, $level);
        }
    }

    public function addPokemon($type, $level) {
        if($this->getType($type) === false && ($level > 0 && $level <= 30)) {
            return false;
        }

        return $this->repository->insert($type, $level);

    }
}