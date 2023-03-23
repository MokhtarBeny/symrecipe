# Bienvenue sur mon Projet Shoes ISLAND


C'est un de gestion de recette que j'ai développé via le framework symfony qui se base sur un MVC (modèle/vue/ controller).
Il permet aux utilisateurs de créer un compte avec des recettes/ ingrédients.
J'ai intégrer des formulaires pour chaque CRUD ce qui permet a l'utilisateur d'alimenter son compte en recette et ingrédient et une gestion public / privé de toutes ses recettes.
J'ai intégré également l'api EasyAdmin qui permet à un ou plusieurs administrateurs de gérer diférrents CRUD lié aux différentes entités de la base de données.

## Vue de l'accueil: 

![Markdown Logo](https://www.zupimages.net/up/23/12/vuse.png)

Dans l'accueil , j'ai introduit une NavBar qui est modifié en fonction du contexte, si l'utilisateur est connecté cela permet d'accéder a ses recettes.
Si il possède on rôle administrateur cela permet d'accès au panneau d'administateur et la barre de navigation s'adapte en fonction de l'utilisateur


# Gestion d'un Controller 


![Markdown Logo](https://www.zupimages.net/up/23/12/tm4l.png)

Ici le controller "RecipeController" nous permet de gérer plusieurs routes et de créér/modifier/suprimmer une recette.
ainsi que d'afficher uniquement les recettes publics/privés.
La premiere 

nous avons la route ci-dessous

```
#[IsGranted('ROLE_USER')]
#[Route('/recette/creation', 'recipe.new', methods: ['GET', 'POST'])] 
```
qui permet la création d'une nouvelle recette via la formulaire ci-dessous :

![Markdown Logo](https://www.zupimages.net/up/23/12/y0uc.png)


# TEST UNIQUE ET FONCTIONNEL


J'ai effectué une serie de test unitaire & fonctionnel afin de me familiariser avec différentes scénario possibles et vérifier que le plupart des fonctionnalités ne comportaient pas de bug.

Via le WebtestCase , j'ai pu tester que l'ajout d'un ingrédient fonctionne correctement.

Voici un apercu du test en question :

![Markdown Logo](https://www.zupimages.net/up/23/12/lebg.png)


J'ai intégré une Api EasyAdmin qui nos permet d'accéder a un panneau d'administrateur :


![Markdown Logo](https://www.zupimages.net/up/23/12/bb4l.png)


Pour toutes questions supplémentaires ou clarification , n'hésitez pas a me contacter.