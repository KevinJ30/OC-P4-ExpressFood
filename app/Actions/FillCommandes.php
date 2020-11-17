<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class FillCommandes extends AbstractFill {

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
     * Crée un utilisateur donnée dans la table
     * 
     * @param string $account_type : Type d'utilisateur que l'on souhaite créer
     * @param string $number : Nombre de d'utilisateur à créer
     * @param string $starIndex : L'index auquel doit démarrer l(ajout dans la table)
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

    public function createCommandeContents() : void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $commandeContent = [
                $i + 1,
                rand(1, 3),
                rand(1, 10),
                rand(1, 10)
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
     * Remplie la base de données
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