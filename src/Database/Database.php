<?php

namespace MiniSpeed\Database;

use PDO;
use PDOException;

class Database {
    protected $pdo;
    private static $raw = [
        "select"=>"SELECT *"
    ];

    public function __construct(array $config) {
        $dsn = sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['database']);
    
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConn(){
        return $this->pdo;
    }

    public function select(array $column = null): void {
        $default = "*";
    
        if ($column !== null) {
            if (is_string($column)) {
                $default = $column;
            } elseif (is_array($column) && count($column) > 0) {
                $default = implode(',', $column);
            }
        }
        
        self::$raw["select"] = "SELECT {$default}";
    }

    public function insert(string $tableName, array $data = []): mixed {
        try {
            $columns = implode(',', array_keys($data));
            $values = implode(',', array_map(fn($value) => ":$value", array_keys($data)));
    
            $stmt = $this->pdo->prepare("INSERT INTO $tableName ($columns) VALUES ($values)");
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            return (int) $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update(string $tableName, array $data = [], array $where = [] ) : bool {
        $tmp = [];
        foreach ($data as $key => $value) {
            $tmp[] = "{$key} = :{$key}";
        }
        $set = implode(",",$tmp);
        $keyWhere = implode("",array_keys($where));
        $valueWhere = (int) implode("",array_values($where));
        $stmt = $this->pdo->prepare("UPDATE {$tableName} SET {$set} WHERE {$keyWhere} = :{$keyWhere}");
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":{$keyWhere}",$valueWhere);
        return $stmt->execute();
    }

    public function delete(string $tableName, array $where = []) : bool {
        $keyWhere = implode("",array_keys($where));
        $valueWhere = (int) implode("",array_values($where));
        $stmt = $this->pdo->prepare("DELETE FROM {$tableName} WHERE {$keyWhere} = :{$keyWhere}");
        $stmt->bindValue(":{$keyWhere}",$valueWhere);
        return $stmt->execute();
    }


    public function query(string $query) {
        return $this->pdo->query($query);
    }

    public function get(string $name){
        $select = self::$raw['select'];
        return $this->query("{$select} from {$name}")->fetchAll(PDO::FETCH_ASSOC);
    }
}
