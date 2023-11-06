<?php

namespace Src\Repositories;

use Generator;
use PDO;
use Src\Contracts\Repositories\IMetricRepository;

class DbMetricRepository implements IMetricRepository
{

    private PDO $connection;

    public function __construct()
    {
        $driver = getenv('DB_CONNECTION');
        $host = getenv('DB_HOST');
        $db = getenv('DB_DATABASE');
        $userName = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        $this->connection = new PDO("$driver:host=$host;dbname=$db", $userName, $password);
    }

    /**
     * Saving metrics data
     * @param array $metrics
     * @return void
     */
    public function insert(array $metrics): void
    {
        $fields = array_keys($metrics);
        $columns = implode(', ', $fields);
        $binds = implode(', ', array_map(fn ($field) => ":$field", $fields));


        $sql = "INSERT INTO metrics ($columns) VALUES ($binds)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($metrics);
    }

    /**
     * Update metrics data
     * @param array $metrics
     * @param array $conditions
     * @return void
     */
    public function update(array $metrics, array $conditions): void
    {
        $fields = array_keys($metrics);
        $set = implode(', ', array_map(fn ($field) => "$field = :$field", $fields));
        $where = '';

        if (count($conditions) > 0)
            $where = 'WHERE '.implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));

        $sql = "UPDATE metrics SET $set $where";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_merge($metrics, $conditions));
    }

    /**
     * Check if the metric exists
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        $sql = "SELECT EXISTS (SELECT id FROM metrics WHERE ad_id = ?) AS isExist";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (bool) $result['isExist'];
    }

    /**
     * Get all the data
     * @return Generator
     */
    public function getAll(): Generator
    {
        $sql = "SELECT * FROM metrics";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $metric) {
            yield $metric;
        }
    }
}
