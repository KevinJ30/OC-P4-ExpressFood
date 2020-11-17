<?php

declare(strict_types=1);

namespace App\Actions;

use PDOException;
use Faker\Factory;

/**
 * Remplie la table users
 **/
class FillMenus extends AbstractFill {

    /**
     * Crée les menus dans la table
     * @return void
     **/
    public function createMenus(): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $menu = [
                $i +1,
                $faker->date('Y-m-d'),
                $faker->sentence(5)
            ];
            
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO menus(id, created_at, name) VALUES(?, ?, ?)');
                $req->execute($menu);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }

        echo $i . ' menus ont été ajoutés.' . "\n";
    }

    /**
     * Ajoute deux plat dans le menu
     * @param int $menu_id : id du menu
     * @return void
     **/
    public function addRecipePlat(int $menu_id): void {
        for($i = 0; $i < 2; $i++) {
            $menuContent = [
                rand(1, 5),
                $menu_id,
                rand(1, 5)
            ];
    
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO menu_contents(recipe_id, menu_id, quantity) VALUES(?, ?, ?)');
                $req->execute($menuContent);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }
    }

    /**
     * Ajoute deux desserts dans le menu
     * @param int $menu_id : Id du menu
     * @return void
     **/
    public function addRecipeDesserts(int $menu_id): void {
        for($i = 0; $i < 2; $i++) {
            $menuContent = [
                rand(6, 10),
                $menu_id,
                rand(1, 5)
            ];
    
            try{
                $req = $this->database->getDatabase()->prepare('INSERT INTO menu_contents(recipe_id, menu_id, quantity) VALUES(?, ?, ?)');
                $req->execute($menuContent);
            } catch(PDOException $e) {
                var_dump($e->getMessage());
            }
        }
    }
    
    /**
     * Créer les contenu des menus
     * @return void
     **/
    public function createMenuContents(): void {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $this->addRecipePlat($i + 1);
            $this->addRecipeDesserts($i + 1);
        }

        echo $i . ' contenu de menu ont été ajoutés.' . "\n";
    }

    /**
     * Vide et injecte les données dans la table
     **/
    public function fillTable() : void {
        $this->truncate('menus');
        $this->truncate('menu_contents');

        // Création 10 menus dans la base de données
        $this->createMenus();

        // Création 10 contenu de menu dans la base de données
        $this->createMenuContents();
    }
}