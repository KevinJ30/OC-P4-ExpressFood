<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;
use App\Actions\AbstractFill;

/**
 * Remplie la table users
 **/
class FillUsers extends AbstractFill {

    /**
     * Crée les utilisateurs dans la table
     * 
     * @param string $account_type : Type d'utilisateur que l'on souhaite créer
     * @param string $number : Nombre de d'utilisateur à créer
     * @param string $starIndex : L'index auquel doit démarrer l(ajout dans la table)
     * @return void
     **/
    public static function createUsers(\PDO $database, string $account_type, int $number,int $startIndex): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < $number; $i++) {
            $client = [
                $startIndex + $i + 1,
                $faker->lastName,
                $faker->firstName,
                $faker->email,
                $faker->phoneNumber,
                sha1($faker->password),
                date('Y-m-d'),
                $account_type,
                rand(1, 10)
            ];
            
            try{
                $req = $database->prepare('INSERT INTO users(id, lastname, firstname, email, phone, password, created_at, account_type, adresse_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $req->execute($client);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' ' . $account_type . ' ont été ajoutés.' . "\n";
    }

    /**
     * Vides et injectes les données dans la table
     **/
    public function fillTable() : void {
        $this->truncate('users');

        // Création des 5 clients
        self::createUsers($this->database->getDatabase(), 'client', 5, 0);

        // Création des 5 chefs
        self::createUsers($this->database->getDatabase(), 'chefs', 5, 5);

        // Création des 5 livreurs
        self::createUsers($this->database->getDatabase(), 'livreurs', 5, 10);
    }
}