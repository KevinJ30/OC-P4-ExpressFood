<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class FillCommandes extends AbstractFill {

    /**
     * @return string : Retourne un status aléatoire pour les commandes
     **/
    private function rand_status() : ?string {
        $rand = rand(0, 2);

        switch($rand) {
            case 0:
                return null;
                break;

            case 1:
                return 'En cours de livraison';
                break;

            case 2:
                return 'Livré';
                break;
        }
    }

    /**
     * Créer les commande de la table commandes
     * @return void
     **/
    public function createCommandes(): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $commande = [
                $i + 1,
                $faker->date('Y-m-d'),
                $this->rand_status(),
                $faker->randomFloat(2, 1, 20),
                rand(1, 5),
                rand(11, 15),
            ];
            
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO commandes(id, created_at, status, amount, client_id, livreur_id) VALUES(?, ?, ?, ?, ?, ?)');
                $req->execute($commande);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' commande ont été ajoutés.' . "\n";
    }

    /**
     * Créer le contenu des commandes
     * 
     * @return void 
     */
    public function createCommandeContents() : void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $commandeContent = [
                $i + 1,
                rand(1, 3),
                rand(1, 10),
                $i + 1
            ];
            
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO commande_contents(id, quantity, recipe_id, commande_id) VALUES(?, ?, ?, ?)');
                $req->execute($commandeContent);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' cotenu de commande ont été ajoutés.' . "\n";
    }

    /**
     * Vide et injecte les données dans les tables
     * commandes et commande_contents
     **/
    public function fillTable() : void {
        $this->truncate('commandes');
        $this->truncate('commande_contents');

        // Création 10 commandes dans la base de données
        $this->createCommandes();

        // Créer 10 contenu de commande
        $this->createCommandeContents();
    }
}