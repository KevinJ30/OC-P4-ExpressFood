<?php
namespace App\Database;

/**
 * Class Database
 **/
class Database {

    /**
     * @var array : Configuration de la base de données.
     **/
    private $configuration;

    /**
     * @param Array $configuration : Configuration de la base de données
     **/
    public function __construct(Array $configuration) {
        $this->configuration = $configuration;
    }

    /**
     * @return \PDO : instance de PDO
     **/
    public function getDatabase(): \PDO {
        try {
            $pdo = new \PDO($this->configuration['driver'] . 
                ':dbname=' . $this->configuration['dbname'] . 
                ';host=' . $this->configuration['host'], 
                $this->configuration['username'],
                $this->configuration['password']
            );

            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_CLASS);
            $pdo->exec("set foreign_key_checks=0");

            return $pdo;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}