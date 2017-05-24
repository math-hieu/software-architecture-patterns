<?php

namespace Evaneos\Archi\Repository;

interface PokemonDAInterface {
    public function add($type, $level);

    public function getByUuid($uuid);
}