<?php
declare(strict_types = 1);

namespace App\Actions;

use Faker\Factory;
use App\Database\Database;

abstract class AbstractFill {

    protected $database;
    protected $faker;


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

    abstract public function fillTable() : void;
}