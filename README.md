# Les Restes - Application Web Anti-Gaspillage 

**Les Restes** est une application web conçue avec Symfony permettant aux utilisateurs de trouver des recettes de cuisine basées sur les ingrédients qu'ils possèdent déjà chez eux. L'objectif est de réduire le gaspillage alimentaire tout en facilitant la gestion du budget.

## Fonctionnalités clés

* **Moteur de recherche intelligent :** Algorithme de filtrage strict par ingrédients (Logique SQL `HAVING COUNT`).
* **Catalogue complet :** Recherche multicritères par difficulté, catégorie et temps de préparation.
* **Espace Utilisateur :** Création de compte, gestion du profil et ajout de recettes personnelles.
* **Système de Notation :** Évaluation des recettes par la communauté.
* **Design Responsive :** Interface optimisée pour une utilisation sur desktop et mobile (Mobile-First).

## Stack Technique

* **Backend :** PHP 8.2+ / Symfony 7.3+
* **Frontend :** Twig / JavaScript (Vanilla) / CSS (Variables personnalisées)
* **Base de données :** MySQL / MariaDB (via Doctrine ORM)
* **Design :** Figma (Maquettes Haute Fidélité)

## Prérequis

* PHP 8.2 ou supérieur
* Composer
* Symfony CLI
* MySQL / MariaDB

## Installation en local

1. **Cloner le repository :**
```bash
git clone https://github.com/shabadine/lesrestes.git 
cd lesrestes

```

2. **Installer les dépendances :**

```bash
composer install

```

3. **Configurer l'environnement :**
Copiez le fichier `.env` en `.env.local` et configurez votre `DATABASE_URL`.
4. **Initialiser la base de données :**

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load --no-interaction

```

5. **Lancer le projet :**

```bash
symfony serve

```

## Architecture & Sécurité

* **Repository :** Requêtes dynamiques via `QueryBuilder` avec protection systématique contre les injections SQL (requêtes paramétrées).
* **Services :** Centralisation de la logique métier (calcul des moyennes, upload d'images).
* **Sécurité :** Hachage des mots de passe (PasswordHasher), protection CSRF sur les formulaires et gestion des rôles (Role-Based Access Control).

## Maintenance

* **Valider la base de données :**
Vérifie la cohérence des entités et la synchronisation avec MySQL.

```bash
php bin/console doctrine:schema:validate
```
* **Vérifier les vulnérabilités :** 
Vérifie si vos dépendances (vendors) contiennent des failles de sécurité connues.
```bash
symfony check:security 
```
* **Débogage des routes :** 
Affiche la liste complète des URL et des contrôleurs associés. 
```bash
php bin/console debug:router
```
* **Débogage du moteur de recherche :** Vérifie que les services et les Repositories sont correctement injectés.
```bash
php bin/console debug:autowiring recette
```
* **Nettoyage du cache :** 
À utiliser en cas de modification de configuration non prise en compte.
```bash
php bin/console cache:clear
```

## Licence

Projet pédagogique - Titre Professionnel DWWM - DAWAN Toulouse

## Auteur

**Shabadine BAH**  
Formation DWWM Niveau 5 - DAWAN Toulouse  
Graduation : Mars 2026

---

Si ce projet vous intéresse, n'hésitez pas à le star sur GitHub !