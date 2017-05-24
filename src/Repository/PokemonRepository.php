<?php

namespace Evaneos\Archi\Repository;

use Doctrine\DBAL\Connection;

class PokemonRepository {

    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function findAll() {
        $sql = 'SELECT uuid, type, level FROM pokemon.collection';
        $query = $this->db->query($sql);

        return $query->fetchAll();
    }

    public function findByUuid($uuid) {
        $sql = 'SELECT * FROM pokemon.collection WHERE uuid = :uuid';
        $query = $this->db->prepare($sql);
        $query->bindValue('uuid', $uuid);
        $query->execute();

        return $query->fetchAll();
    }

    public function findByType($type){
        $sql = 'SELECT * FROM pokemon.collection WHERE type = :type ';
        $query = $this->db->prepare($sql);
        $query->bindValue('type', $type);
        $query->execute();

        return $query->fetchAll();
    }

    public function insert($type, $level) {
        $uuid = (string) Uuid::uuid4();

        $sql = 'INSERT INTO pokemon.collection (uuid, type, level) VALUES (:uuid, :type, :level)';
        $query = $this->connection->prepare($sql);
        $query->bindValue('uuid', $uuid);
        $query->bindValue('type', $type);
        $query->bindValue('level', $level);
        $query->execute();

        return $uuid;
    }

}