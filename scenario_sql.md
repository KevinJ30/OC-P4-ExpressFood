# Tester la base de données ExpressFood

## Scénario

### Le client ( Lambert id : 1  ) :
    1. Le client affiche le menu du jour ( date = 2012-04-13 )
    
    2. Il créer une nouvelle commande

    3. Il ajoute le contenu de sa commande
    
    4. Attribue le livreur a la commande et mets a jour le status du livreur, 
       met a jour le montant de la commande

    5. Le client demande à affiché le contenu et le prix total de sa commande 
    
### Le chef :
    6. Affiche la liste des plats enregistré et affiche la liste des desserts

    7. Créer un nouveau menus

    8. Ajouter le contenu du menu

    9. Consulter le contenu du menu précédement créer

### Le livreur :
    10. Le livreur commence sa journée et remplie son sac
    
    11. Le livreur souhaite découvrire la commande qui lui a été attribué

    12. Le livreur affiche les informations de son client

    13. Le livreur affiche sont chiffre d'affaire du 05/09/2005

    14. Le livreur affiche le contenu de son sac

## Requête SQL :

### Client ( Lambert id : 1  )
    1. SELECT * FROM menus WHERE created_at = "2012/04/13" LIMIT 1;

    2. INSERT INTO commandes(id, created_at, status, client_id) VALUES(11, '2020/11/17', null, 1);

    3. INSERT INTO commande_contents(quantity, recipe_id, commande_id) 
       VALUES(2, 1, 11), (1, 2, 11);

    4. UPDATE commandes SET livreur_id = 11 SET status = 'attributed' SET amount = 10.17 WHERE id = 11, 
       UPDATE users SET state = 'occupied' WHERE id = 11

    5. 
    
    SELECT
        commandes.livreur_id as commande_livreur,
        commande_contents.id as content_id,
        commande_contents.quantity as content_quantity,
        recipes.id as recipe_id,
        recipes.name as recipe_name,
        recipes.type_recipe as recipe_type,
        recipes.prix as recipe_prix,
        recipes.thumb as recipe_thumb,
        users.id as livreur_id,
        users.lastname as livreur_lastname,
        users.firstname as livreur_firstname,
        users.longitude as livreur_longitude,
        users.latitude as livreur_latitude
    FROM commande_contents 
    LEFT JOIN recipes ON commande_contents.recipe_id = recipes.id
    LEFT JOIN commandes ON commandes.id = commande_contents.commande_id
    LEFT JOIN users ON users.id = commandes.livreur_id
    WHERE commande_id = 11

    SELECT
	    ROUND(SUM(recipes.prix * commande_contents.quantity), 2) as montant_total_commande
    FROM commande_contents 
    LEFT JOIN recipes ON commande_contents.recipe_id = recipes.id
    LEFT JOIN commandes ON commandes.id = commande_contents.commande_id
    WHERE commande_id = 11

### Chef
    6. SELECT * FROM recipes WHERE type_recipe = 'plat'
       SELECT * FROM recipes WHERE type_recipe = 'dessert'
    
    7. INSERT INTO menus(id, created_at, name) VALUES(11, '2020/11/17', 'Le plat du bonheur')

    8. INSERT INTO menu_contents(menu_id, recipe_id, quantity) 
       VALUES(11, 3, 10), (11, 4, 10), (11, 8, 10), (11, 10, 10)

    9. 

    SELECT
	    menus.id as menu_id,
        menus.created_at as menu_created_at,
        menus.name as menu_name,
	    recipes.id as recipe_id,
        recipes.name as recipe_name,
        recipes.type_recipe as recipe_type,
        recipes.description as recipe_description,
        recipes.prix as recipe_prix,
        recipes.thumb as recipe_thumb
    FROM menu_contents
    LEFT JOIN menus ON menu_contents.menu_id = menus.id
    LEFT JOIN recipes ON menu_contents.recipe_id = recipes.id 
    WHERE menu_contents.menu_id = 11

### Livreur
  
    10. INSERT INTO bags(id, recipe_id, user_id, quantity) 
       VALUES(6, 1, 1, 10), (7, 2, 1, 10), (8, 8, 1, 10), (9, 10, 1, 10);

    11. SELECT * FROM commandes 
        WHERE livreur_id = 11 AND status = 'attributed';

    12. SELECT * FROM commandes
        LEFT JOIN users ON commandes.client_id = users.id
        WHERE livreur_id = 11 AND status = 'attributed'

    13. SELECT 
	        ROUND(SUM(amount), 2) as chiffre_affaire
        FROM commandes
        WHERE livreur_id = 11 AND created_at > '2020/11/01' AND created_at < '2020/11/30'
    
    14. SELECT 
            * 
        FROM bags
        LEFT JOIN recipes ON bags.recipe_id = recipes.id
        WHERE bags.user_id = 11




