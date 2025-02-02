<?php

namespace App\ORM;

use ReflectionClass;
use ReflectionProperty;
use App\Service\ClassFinder;
use PDO;

class DBHandler
{
    private $connection = [
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'dbname' => 'ollyo_events',
    ];

    public function __construct(
        private ClassFinder $classFinder
    ) {}

    public function getConnection(): PDO
    {
        $dsn = 'mysql:host=' . $this->connection['host'] . ';dbname=' . $this->connection['dbname'] . ';port=' . $this->connection['port'];
        return new PDO($dsn, $this->connection['user'], $this->connection['password']);
    }

    public function updateSchema(): void
    {
        $namespace = 'App\\Blueprint';
        $classes = $this->classFinder->getClassesUnderNamespace($namespace);

        foreach ($classes as $class) {
            $reflection = new ReflectionClass($class);
            $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
            $tableName = $class::tableName();

            if (!$this->tableExists($tableName)) {
                $this->createTable($tableName, $properties);
            } else {
                $this->syncTable($tableName, $properties);
            }
        }
    }

    private function tableExists(string $tableName): bool
    {
        $sql = "SHOW TABLES LIKE ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$tableName]);
        return $stmt->rowCount() > 0;
    }

    private function createTable(string $tableName, array $properties): void
    {
        $columns = [];
        foreach ($properties as $property) {
            $type = (string) $property->getType();
            $columnType = $this->mapTypeToSQL($type);
            $columns[] = $property->getName() . ' ' . $columnType;
        }

        $columnsSql = implode(', ', $columns);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsSql);";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
    }

    private function syncTable(string $tableName, array $properties): void
    {
        $existingColumns = $this->getExistingColumns($tableName);
        $newColumns = [];
        $propertiesNames = array_map(fn($property) => $property->getName(), $properties);

        foreach ($properties as $property) {
            $columnName = $property->getName();
            if (!in_array($columnName, $existingColumns)) {
                $type = (string) $property->getType();
                $columnType = $this->mapTypeToSQL($type);
                $newColumns[] = "ADD COLUMN $columnName $columnType";
            }
        }

        foreach ($existingColumns as $existingColumn) {
            if (!in_array($existingColumn, $propertiesNames)) {
                $newColumns[] = "DROP COLUMN $existingColumn";
            }
        }

        if (!empty($newColumns)) {
            $alterSql = "ALTER TABLE $tableName " . implode(', ', $newColumns);
            $stmt = $this->getConnection()->prepare($alterSql);
            $stmt->execute();
        }
    }

    private function getExistingColumns(string $tableName): array
    {
        $sql = "SHOW COLUMNS FROM $tableName";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'Field');
    }

    private function mapTypeToSQL(string $type): string
    {
        switch ($type) {
            case 'string':
                return 'VARCHAR(255)';
            case 'int':
                return 'INT';
            case 'float':
                return 'FLOAT';
            case 'bool':
                return 'TINYINT(1)';
            case 'DateTime':
                return 'DATETIME';
            default:
                throw new \InvalidArgumentException("Unsupported type: $type");
        }
    }
}
