<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class FillAdresses extends AbstractFill {
    const CITY = [
        'Paris',
        'Avignon',
        'Marseille',
        'Lyon',
        'Grenoble',
        'Strasbourg'
    ];

    /**
     * Crée un utilisateur donnée dans la table
     * 
     * @param string $account_type : Type d'utilisateur que l'on souhaite créer
     * @param string $number : Nombre de d'utilisateur à créer
     * @param string $starIndex : L'index auquel doit démarrer l(ajout dans la table)
     * @return void
     **/
    public function createAdresses(): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $addresse = [
                $i + 1,
                $faker->buildingNumber,
                $faker->streetName,
                self::CITY[rand(0, 5)],
                $faker->postcode
            ];
            
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO adresses(id, number, rue, ville, postal) VALUES(?, ?, ?, ?, ?)');
                $req->execute($addresse);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' adresses ont été ajoutés.' . "\n";
    }

    /**
     * Remplie la base de données
     **/
    public function fillTable() : void {
        $this->truncate('adresses');

        // Création des 5 adresses dans la base de données
        $this->createAdresses();
    }
}