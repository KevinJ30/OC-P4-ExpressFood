<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class Fillbags extends AbstractFill {
    /**
     * Crée les sacs dans la table bags
     * @return void
     **/
    public function createBags(): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 5; $i++) {
            $bag = [
                $i + 1,
                rand(1, 10),
                rand(1, 10),
                rand(11, 15)
            ];
            
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO bags(id, quantity, recipe_id, user_id) VALUES(?, ?, ?, ?)');
                $req->execute($bag);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' sacs ont été ajoutés.' . "\n";
    }

    /**
     * Vide et injecte les données dans la table
     **/
    public function fillTable() : void {
        $this->truncate('bags');

        // Création des 5 sacs dans la base de données
        $this->createbags();
    }
}