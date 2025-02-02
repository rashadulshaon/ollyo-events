<?php

namespace App\Database;

use App\Container;
use PDO;

abstract class AbstractBlueprint
{
    private $container;
    private $db;

    public function __construct()
    {
        $this->container = new Container();
        $this->db = $this->container->get(SchemaHandler::class);
    }

    abstract static protected function tableName(): string;

    public function create(array $data): array
    {
        $tableName = $this->tableName();
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute(array_values($data));

        return ['id' => $this->db->getConnection()->lastInsertId()];
    }

    public function read(int $id): array
    {
        $tableName = $this->tableName();
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function readMultiple(array $filters = [], int $itemsPerPage = 10, int $pageNumber = 1): array
    {
        $tableName = $this->tableName();
        $whereClauses = [];
        $params = [];

        if ($filters) {
            foreach ($filters as $key => $value) {
                $whereClauses[] = "$key = ?";
                $params[] = $value;
            }
        }

        $whereSql = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

        $offset = ($pageNumber - 1) * $itemsPerPage;

        $sql = "SELECT * FROM $tableName $whereSql LIMIT $itemsPerPage OFFSET $offset";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data): array
    {
        $tableName = $this->tableName();
        $setClauses = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setClauses[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $setSql = implode(', ', $setClauses);
        $sql = "UPDATE $tableName SET $setSql WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);

        return ['id' => $id];
    }

    public function delete(int $id): bool
    {
        $tableName = $this->tableName();
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute([$id]);
    }
}
