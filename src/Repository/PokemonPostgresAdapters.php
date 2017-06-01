<?php

namespace Evaneos\Archi\Repository;

use Doctrine\DBAL\Connection;

class PokemonPostgresAdapters implements PokemonDAInterface {

    private $db;

    public function __construct(Connection $connection) {
        $this->db = $connection;
    }

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