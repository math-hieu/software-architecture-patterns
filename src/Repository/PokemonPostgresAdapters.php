<?php

namespace Evaneos\Archi\Repository;

class PokemonPostgresAdapters implements PokemonDAInterface {
    public function add($type, $level) {

    }

    public function getByUuid($uuid) {
        $sql = 'SELECT * FROM pokemon.collection WHERE uuid = :uuid';
        $query = $this->db->prepare($sql);
        $query->bindValue('uuid', $uuid);
        $query->execute();

        return $query->fetchAll();
    }
}