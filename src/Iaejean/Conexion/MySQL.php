<?php
declare(strict_types=1);

namespace Iaejean\Conexion;

/**
 * Class MySQL
 * @package Iaejean\Conexion
 */
class MySQL
{
    /**
     * @var MySQL
     */
    private static $instance;
    /**
     * @var \PDO
     */
    private $link;

    /**
     * MySQL constructor.
     */
    protected function __construct()
    {
        $conf = require CONF_FILE;
        $host = $conf['database']['host'];
        $user = $conf['database']['user'];
        $pass = $conf['database']['pass'];
        $name = $conf['database']['name'];

        $this->link = new \PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
        $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->link->exec('SET CHARACTER SET utf8');
        $this->link->beginTransaction();
    }

    /**
     * @return MySQL
     */
    public static function getInstance(): MySQL
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self;
    }

    /**
     * @param $sql
     * @return \PDOStatement
     */
    public function prepare(string $sql): \PDOStatement
    {
        return $this->link->prepare($sql);
    }

    /**
     * @param string $fields
     * @param string $table
     * @param string $filter
     * @return array
     * @throws \PDOException
     */
    public function select(string $fields, string $table, string $filter = ''): array
    {
        try {
            $sql = 'SELECT ' . $fields . ' FROM ' . $table . ' WHERE 1 ' . $filter;
            $result = $this->link->query($sql);
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->link->rollBack();
            throw $e;
        }
    }

    /**
     * @param string $table
     * @param array $values
     * @return int
     * @throws \PDOException
     */
    public function insert(string $table, array $values): int
    {
        try {
            $keys = $keysPoints = $arrayValue = [];

            foreach ($values as $key => $value) {
                $keys[] = $key;
                $keysPoints[] = ':'.$key;
                $arrayValue[':'.$key] = $value;
            }

            $fields = implode(',', $keys);
            $data = implode(',', $keysPoints);
            $sql = 'INSERT INTO ' . $table . '(' . $fields . ') VALUES (' . $data . ');';
            $stmt = $this->link->prepare($sql);
            $stmt->execute($arrayValue);
            return (int)$this->link->lastInsertId();
        } catch (\PDOException $e) {
            $this->link->rollBack();
            throw $e;
        }
    }

    /**
     * @param string $table
     * @param array $values
     * @param array $filters
     * @return bool
     * @throws \PDOException
     */
    public function update(string $table, array $values = array(), array $filters = array()): bool
    {
        try {
            $fields = $valuesAux = $arrayStm = [];

            foreach ($values as $key => $value) {
                $fields[] = $key . ' = :'.$key;
                $arrayStm[':'.$key] = $value;
            }

            foreach ($filters as $key => $value) {
                $valuesAux[] = $key . ' = :' . $key;
                $arrayStm[':'.$key] = $value;
            }

            $fields = implode(', ', $fields);
            $valuesAux = implode(' AND ', $valuesAux);
            $sql = 'UPDATE ' . $table . ' SET ' . $fields  . ' WHERE ' . $valuesAux. ';';
            $stmt = $this->link->prepare($sql);
            return $stmt->execute($arrayStm);
        } catch (\PDOException $e) {
            $this->link->rollBack();
            throw $e;
        }
    }

    public function __destruct()
    {
        if ($this->link instanceof \PDO) {
            $this->link->commit();
            $this->link = null;
        }
    }
}
