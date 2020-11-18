<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class FillRecipe extends AbstractFill {

    /**
     * @var array : Rectte pré-construite
     **/
    const RECIPES = [
        'PLATS' => [
            'Blanquette de veau',
            'Boeuf bourguignon',
            'Lasagne à la bolognaise',
            'Tacos mexicains',
            'Moussaka Grecque'
        ],

        'DESSERTS' => [
            'Fondant au chocolat',
            'Tiramissu',
            'Tarte aux pommes',
            'Cheese cake spéculos',
            'Crème brûlée'
        ]
    ];

    /**
     * Crée les recettes dans la table
     * 
     * @param string $recipe_type : Type d'utilisateur que l'on souhaite créer
     * @param int $number : Nombre de d'utilisateur à créer
     * @param int  $starIndex : L'index auquel doit démarrer l'ajout dans la table)
     * @return void
     **/
    public static function createRecipe(\PDO $database, string $recipe_type, int $number,int $startIndex): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < $number; $i++) {
            $recipe = [
                $startIndex + $i + 1,
                self::RECIPES[strtoupper($recipe_type).'S'][$i],
                $recipe_type,
                $faker->sentence(100),
                $faker->randomFloat(2, 1, 8)
            ];
            
            try{
                $req = $database->prepare('INSERT INTO recipes(id, name, type_recipe, description, prix) VALUES(?, ?, ?, ?, ?)');
                $req->execute($recipe);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' ' . $recipe_type . ' ont été ajoutés.' . "\n";
    }

    /**
     * Vides et injectes les données dans la table
     **/
    public function fillTable() : void {
        $this->truncate('recipes');

        // Création des 5 clients
        self::createRecipe($this->database->getDatabase(), 'plat', 5, 0);

        // Création des desserts
        self::createRecipe($this->database->getDatabase(), 'dessert', 5, 5);    
    }
}