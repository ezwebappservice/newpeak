<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

/**
 * CodeIgniter 3 style database wrapper for migrated models.
 */
class CI3Database
{
    protected BaseConnection $connection;

    /** @var list<string>|string */
    protected $selectFields = '*';

    protected ?string $fromTable = null;

    /** @var list<array{0: mixed, 1: mixed, 2: mixed|null}> */
    protected array $pendingWheres = [];

    /** @var list<array{0: string, 1: string, 2: string}> */
    protected array $pendingJoins = [];

    protected ?string $orderField = null;

    protected string $orderDirection = '';

    protected ?int $limitCount = null;

    protected ?int $limitOffset = null;

    public function __construct(?BaseConnection $connection = null)
    {
        $this->connection = $connection ?? \Config\Database::connect();
    }

    public function query(string $sql, $binds = null)
    {
        return $this->connection->query($sql, $binds);
    }

    public function table(string $name)
    {
        $builder = $this->connection->table($name);

        foreach ($this->pendingWheres as [$key, $value, $escape]) {
            $builder->where($key, $value, $escape);
        }

        $this->resetQueryState();

        return $builder;
    }

    public function select($fields = '*', $escape = null)
    {
        $this->selectFields = $fields;

        return $this;
    }

    public function from(string $table)
    {
        $this->fromTable = $table;

        return $this;
    }

    public function join(string $table, string $cond, string $type = '', ?bool $escape = null)
    {
        $this->pendingJoins[] = [$table, $cond, $type];

        return $this;
    }

    public function where($key, $value = null, $escape = null)
    {
        $this->pendingWheres[] = [$key, $value, $escape];

        return $this;
    }

    public function order_by(string $orderBy, string $direction = '', ?bool $escape = null)
    {
        $this->orderField = $orderBy;
        $this->orderDirection = $direction;

        return $this;
    }

    public function limit(?int $value = null, ?int $offset = 0)
    {
        $this->limitCount = $value;
        $this->limitOffset = $offset ?? 0;

        return $this;
    }

    public function get(?string $table = null, ?int $limit = null, ?int $offset = 0)
    {
        if ($table !== null) {
            $this->fromTable = $table;
        }

        if ($this->fromTable === null) {
            throw new \RuntimeException('Database query requires from() or table name in get().');
        }

        $builder = $this->connection->table($this->fromTable);
        $builder->select($this->selectFields);

        foreach ($this->pendingJoins as [$joinTable, $cond, $type]) {
            $builder->join($joinTable, $cond, $type);
        }

        foreach ($this->pendingWheres as [$key, $value, $escape]) {
            $builder->where($key, $value, $escape);
        }

        if ($this->orderField !== null) {
            $builder->orderBy($this->orderField, $this->orderDirection);
        }

        $limit ??= $this->limitCount;
        $offset = $this->limitOffset ?? $offset;

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $result = $builder->get();
        $this->resetQueryState();

        return $result;
    }

    public function insert_id(): int
    {
        return $this->connection->insertID();
    }

    public function insertID(): int
    {
        return $this->insert_id();
    }

    protected function resetQueryState(): void
    {
        $this->selectFields = '*';
        $this->fromTable = null;
        $this->pendingWheres = [];
        $this->pendingJoins = [];
        $this->orderField = null;
        $this->orderDirection = '';
        $this->limitCount = null;
        $this->limitOffset = null;
    }
}
