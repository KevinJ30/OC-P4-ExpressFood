<?php

use Faker\Factory;
use App\Actions\FillBags;
use App\Actions\FillMenus;
use App\Actions\FillUsers;
use App\Database\Database;
use App\Actions\FillRecipe;
use App\Actions\FillAdresses;
use App\Actions\FillCommandes;

require 'vendor/autoload.php';


$configurationDatabase = [
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'oc_expressfood_v2',
    'username' => 'root',
    'password' => ''
];

$faker = new Factory('fr_FR');

$database = new App\Database\Database($configurationDatabase);

$fillAdresse = new FillAdresses($database, $faker);
$fillAdresse->fillTable();

$fillUsers = new FillUsers($database, $faker);
$fillUsers->fillTable();

$fillRecipe = new FillRecipe($database, $faker);
$fillRecipe->fillTable();

$fillCommandes = new FillCommandes($database, $faker);
$fillCommandes->fillTable();

$fillMenus = new FillMenus($database, $faker);
$fillMenus->fillTable();

$fillBags = new FillBags($database, $faker);
$fillBags->fillTable();