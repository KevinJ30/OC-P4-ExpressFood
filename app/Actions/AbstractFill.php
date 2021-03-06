<?php
declare(strict_types = 1);

namespace App\Actions;

use Faker\Factory;
use App\Database\Database;

/**
 * Class Abstraite Fill
 **/
abstract class AbstractFill {

    /**
     * @var Database $database : Instance database
     **/
    protected $database;

    /**
     * @var Factory $faker : Instance de faker
     **/
    protected $faker;


    /**
     * Constructor
     * 
     * @var Database $database
     * @var Factory $faker
     **/
    public function __construct(Database $database, Factory $faker) {
        $this->database = $database;
        $this->faker = $faker;
    }

    /**
     * Vide le contenu d'une table
     * 
     * @param string $table : Table que l'on souhaite vider
     **/
    public function truncate(string $table) : void {
        $this->database->getDatabase()->exec('DELETE FROM ' . $table);
    }

    /**
     * Implement method : injection des données dans la base de données
     * @return void
     **/
    abstract public function fillTable() : void;
}