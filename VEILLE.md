# VEILLE TECHNOLOGIQUE

## Application Les Restes - Documentation de Veille

**Projet** : Les Restes - Application Anti-Gaspillage Alimentaire  
**Auteur** : Shabadine BAH  
**Formation** : DWWM Niveau 5 - DAWAN Toulouse  
**Période** : Novembre 2025 - Mars 2026

---

## Table des matières

1. [Introduction et méthodologie](#introduction-et-méthodologie)
2. [Sources de veille consultées](#sources-de-veille-consultées)
3. [Technologies et outils découverts](#technologies-et-outils-découverts)
4. [Articles et ressources marquants](#articles-et-ressources-marquants)
5. [Évolutions envisagées](#évolutions-envisagées-pour-les-restes)
6. [Capitalisation des apprentissages](#capitalisation-des-apprentissages)
7. [Plan de veille continue](#plan-de-veille-continue)

---

## Introduction et méthodologie

### Pourquoi la veille technologique ?

Dans le domaine du développement web, les technologies évoluent rapidement. Une veille technologique structurée permet de :

- **Rester à jour** sur les nouvelles versions des frameworks et langages
- **Découvrir de nouvelles solutions** aux problèmes techniques rencontrés
- **Anticiper les dépréciations** et préparer les migrations
- **Améliorer la qualité** du code grâce aux bonnes pratiques émergentes
- **Se former en continu** sur les standards du marché

### Ma méthode de veille

J'ai adopté une approche **pragmatique et documentaire** basée sur trois piliers :

#### 1. Veille curative (Just-in-time)
Lorsque je rencontre un problème technique, je consulte systématiquement :
- La **documentation officielle** (Symfony, PHP.net, MDN)
- Le **Profiler Symfony** pour analyser les logs
- Les **issues GitHub** du projet concerné

Cette approche garantit l'utilisation de solutions à jour et officielles.

#### 2. Veille préventive (Weekly)
Chaque semaine, je consulte :
- Les **newsletters spécialisées** (PHP Weekly, Symfony Station)
- Les **changelogs** des versions Symfony et PHP
- Les **blogs techniques** de référence

#### 3. Veille expérimentale (Monthly)
Chaque mois, je teste en **bac à sable** :
- Un nouveau bundle Symfony
- Une nouvelle fonctionnalité PHP 8.3+
- Un outil d'optimisation ou de qualité

Cette pratique me permet de comprendre "sous le capot" avant d'intégrer en production.

---

##  Sources de veille consultées

### 1. Documentation officielle (quotidien)

| Source | URL | Utilité |
|--------|-----|---------|
| **Symfony Docs** | https://symfony.com/doc | Référence complète du framework |
| **PHP Manual** | https://www.php.net/manual | Documentation officielle PHP |
| **MDN Web Docs** | https://developer.mozilla.org | HTML/CSS/JavaScript, compatibilité navigateurs |
| **MySQL Docs** | https://dev.mysql.com/doc | Optimisation requêtes, index |
| **Bootstrap Docs** | https://getbootstrap.com/docs | Composants UI et grille responsive |

### 2. Sites et blogs techniques (hebdomadaire)

| Source | URL | Fréquence | Type de contenu |
|--------|-----|-----------|-----------------|
| **Symfony Blog** | https://symfony.com/blog | Hebdo | Annonces, nouveautés, best practices |
| **PHP.Watch** | https://php.watch | Hebdo | Nouveautés PHP 8.x, dépréciations |
| **DEV Community** | https://dev.to | 2x/semaine | Articles techniques, retours d'expérience |
| **CSS-Tricks** | https://css-tricks.com | Hebdo | Techniques CSS, responsive, accessibilité |
| **Symfony Casts** | https://symfonycasts.com | Mensuel | Tutoriels vidéo Symfony avancés |
| **Laravel News** | https://laravel-news.com | Hebdo | Actualités PHP et écosystème |

### 3. Newsletters (hebdomadaire)

| Newsletter | Fréquence | Points forts |
|------------|-----------|--------------|
| **PHP Weekly** | Hebdo | Sélection d'articles, nouveaux packages, versions |
| **JavaScript Weekly** | Hebdo | Actualités JavaScript Vanilla et frameworks |
| **Symfony Station** | Hebdo | Tutoriels, bundles, communauté Symfony |
| **Frontend Focus** | Hebdo | HTML/CSS, accessibilité, performance web |

### 4. Réseaux sociaux et communautés (quotidien)

| Plateforme | Comptes suivis | Utilité |
|------------|----------------|---------|
| **Twitter/X** | @symfony, @php, @symfony_com | Annonces, tips, discussions |
| **Reddit** | r/PHP, r/symfony, r/webdev | Discussions, retours d'expérience |
| **Stack Overflow** | Tags: php, symfony, doctrine | Résolution de problèmes concrets |
| **GitHub** | Repositories Symfony, Doctrine | Issues, pull requests, roadmap |

### 5. Podcasts et vidéos (mensuel)

| Source | Fréquence | Thèmes |
|--------|-----------|--------|
| **Symfony Casts Podcast** | Mensuel | Symfony, PHP, développement web |
| **PHP Internals News** | Mensuel | Évolution du langage PHP |
| **Grafikart (YouTube)** | Variable | Tutoriels Symfony, PHP, JavaScript |

---

##  Technologies et outils découverts

### 1. Symfony UX Components 

**Date de découverte** : Décembre 2025  
**Source** : [Article Axopen - Symfony UX](https://www.axopen.com/blog/2025/11/symfony-ux-revolutionnez-facilement-votrefront-end/)

#### Description
Collection officielle de composants JavaScript pour Symfony permettant d'ajouter des interactions modernes sans frameworks lourds (React, Vue.js). Reposent sur **Stimulus** (framework JS léger).

#### Composants identifiés

| Composant | Utilité | Pertinence pour Les Restes |
|-----------|---------|----------------------------|
| **ux-autocomplete** | Champ de recherche avec suggestions | ⭐⭐⭐ Recherche d'ingrédients |
| **ux-live-component** | Composants réactifs en temps réel | ⭐⭐⭐ Système de favoris |
| **ux-chart** | Génération de graphiques | ⭐⭐ Statistiques utilisateur |
| **ux-dropzone** | Upload de fichiers drag & drop | ⭐⭐ Upload images recettes |
| **ux-notify** | Notifications toast | ⭐ Messages flash améliorés |

#### Exemple d'usage potentiel

**Avant (JavaScript Vanilla - actuel) :**
```javascript
// Gestion manuelle des suggestions d'ingrédients
fetch('/api/ingredients/search?q=' + query)
  .then(response => response.json())
  .then(data => {
    // Manipulation DOM manuelle pour afficher les suggestions
  });
```

**Après (Symfony UX Autocomplete) :**
```twig
{{ form_row(form.ingredient, {
    attr: {
        'data-controller': 'symfony--ux-autocomplete--autocomplete',
        'data-symfony--ux-autocomplete--autocomplete-url-value': path('api_ingredients_search')
    }
}) }}
```

**Avantages :**
- Moins de code JavaScript personnalisé
- Maintenance simplifiée
- Accessible par défaut (ARIA intégré)
- Support clavier natif

**Plan d'intégration** : Court terme (3 mois)

---

### 2. PHP-CS-Fixer 

**Date de découverte** : Novembre 2025  
**Source** : [Documentation PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

#### Description
Outil de formatage automatique du code PHP selon les standards **PSR-12**. Analyse les fichiers et applique les corrections de style instantanément.

#### Installation et utilisation

```bash
# Installation
composer require --dev friendsofphp/php-cs-fixer

# Configuration
# Créer .php-cs-fixer.php à la racine
```

**Fichier `.php-cs-fixer.php` :**
```php
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('var')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder($finder);
```

**Commande d'exécution :**
```bash
# Analyser et corriger automatiquement
vendor/bin/php-cs-fixer fix src/

# Mode dry-run (prévisualisation)
vendor/bin/php-cs-fixer fix src/ --dry-run --diff
```

#### Intégration dans le workflow Git

**Hook pre-commit** (`.git/hooks/pre-commit`) :
```bash
#!/bin/bash
vendor/bin/php-cs-fixer fix src/ --dry-run --diff
if [ $? -ne 0 ]; then
    echo " Code non conforme PSR-12. Exécutez: vendor/bin/php-cs-fixer fix"
    exit 1
fi
```

**Avantages :**
- Code uniforme et professionnel
- Facilite les code reviews
- Réduit les conflits Git
- Améliore la lisibilité

**Plan d'intégration** : Court terme (1 mois)

---

### 3. Symfony AssetMapper (UTILISÉ)

**Date de découverte** : Octobre 2025  
**Source** : [Symfony 7.1 Release](https://symfony.com/blog/symfony-7-1-0-released)

#### Description
Alternative moderne à **Webpack Encore** pour gérer les assets (CSS/JS) sans bundler. Utilise les **Import Maps** natifs des navigateurs modernes (ES Modules).

#### Avantages vs Webpack Encore

| Critère | Webpack Encore | AssetMapper |
|---------|----------------|-------------|
| **Node.js requis** |  Oui |  Non |
| **Build step** |  Nécessaire |  Aucun |
| **Complexité** |  Élevée |  Faible |
| **Performance dev** |  Lente (watch) | Instantanée |
| **Performance prod** | Excellente (bundle) | Excellente (HTTP/2) |
| **Courbe d'apprentissage** |  Moyenne |  Faible |

#### Impact sur le projet

**Choix initialement prévu :** Webpack Encore  
**Choix final :** AssetMapper

**Raison du changement :**
- Simplification de l'environnement de développement (pas de `npm install`, `npm run watch`)
- Score Lighthouse Performance de **100%** grâce au chargement parallèle HTTP/2
- Pas de dette technique liée à Node.js et ses dépendances

**Configuration utilisée :**
```php
# config/packages/asset_mapper.yaml
framework:
    asset_mapper:
        paths:
            - assets/
        missing_import_mode: strict # Erreur fatale en dev si un import manque

when@prod:
    framework:
        asset_mapper:
            missing_import_mode: warn # Simple avertissement en prod pour éviter de casser le site
```

**Résultat :** Gain de **+25% en performance** sur Lighthouse par rapport à la version Webpack initiale.



---

### 4. LiipImagineBundle (UTILISÉ & OPTIMISÉ)

**Date de découverte** : Novembre 2025

**Source** : [Documentation LiipImagineBundle](https://symfony.com/bundles/LiipImagineBundle/current/index.html)

#### Description

Bundle utilisé pour l'optimisation des images. Il permet de transformer les uploads utilisateurs (souvent lourds et au format JPEG/PNG) en formats modernes comme le **WebP**, tout en redimensionnant les images à la volée.

#### Configuration réelle implémentée

```yaml
# config/packages/liip_imagine.yaml
liip_imagine:
    twig: { mode: lazy } # Optimisation du rendu Twig
    
    filter_sets:
        # Filtre principal pour le catalogue (Cards)
        thumb_recette:
            quality: 75
            format: webp
            filters:
                thumbnail: { size: [612, 312], mode: outbound }
        
        # Filtre pour la gestion du profil (Conformité Lighthouse)
        profil_full:
            quality: 75
            format: webp
            filters:
                thumbnail: { size: [120, 120], mode: outbound }

```

#### Implémentation Avancée (UX & Performance)

Au-delà de la simple génération d'images, j'ai intégré une logique de **chargement prioritaire** dans mes templates pour maximiser les scores Core Web Vitals :

```twig
{# templates/recette/partials/_recipe_card.html.twig #}

{% set is_priority = loop is defined and loop.index <= 3 %}

<img src="{{ asset('uploads/recettes/' ~ recette.image) | imagine_filter('thumb_recette') }}" 
     class="card-img-top" 
     {% if is_priority %}
        fetchpriority="high"
        loading="eager"
     {% else %}
        loading="lazy"
     {% endif %}
     alt="Photo de la recette : {{ recette.nom }}">

```

---


**Impact mesurable :**
- Réduction du poids des images de **-30%** (JPEG → WebP)
- Temps de chargement des pages catalogue : **-1.2s**
- Score Lighthouse Performance : **100%** (vs 72% sans optimisation)

---

### 5. PHPStan (à intégrer)

**Date de découverte** : Janvier 2026  
**Source** : [PHP Stan](https://phpstan.org/)

#### Description
Analyseur statique de code PHP. Détecte les erreurs **avant l'exécution** (types, méthodes inexistantes, bugs logiques).

#### Niveaux d'analyse

| Niveau | Description |
|--------|-------------|
| 0 | Erreurs de syntaxe basiques |
| 5 | Vérification stricte des types |
| 8 | Maximum (enforce strict_types) |
| max | Niveau le plus strict |

#### Installation

```bash
composer require --dev phpstan/phpstan
composer require --dev phpstan/phpstan-symfony
```

**Configuration `phpstan.neon` :**
```yaml
parameters:
    level: 6
    paths:
        - src
        - tests
    symfony:
        containerXmlPath: var/cache/dev/App_KernelDevDebugContainer.xml
```

**Commande d'exécution :**
```bash
vendor/bin/phpstan analyse src tests
```

**Plan d'intégration** : Moyen terme (3-6 mois)

---

## Articles et ressources marquants

### 1. PHP 8.4 : Nouveautés et améliorations

**Source** : [Kinsta - PHP 8.4](https://kinsta.com/fr/blog/php-8-4/)  
**Date** : Octobre 2025  
**Auteur** : Kinsta Development Team

#### Nouveautés principales

##### 1.1 Property Hooks
Simplification des getters/setters avec une syntaxe inline.

**Avant (PHP 8.3) :**
```php
class Recette
{
    private string $nom;
    
    public function getNom(): string
    {
        return $this->nom;
    }
    
    public function setNom(string $nom): void
    {
        $this->nom = trim($nom);
    }
}
```

**Après (PHP 8.4) :**
```php
class Recette
{
    public string $nom {
        get => $this->nom;
        set => trim($value);
    }
}
```

**Avantages :**
- Moins de code "boilerplate"
- Logique de transformation proche de la propriété
- Meilleure lisibilité

##### 1.2 Asymmetric Visibility
Visibilité différente en lecture et en écriture.

**Exemple :**
```php
class Recette
{
    // Public en lecture, privé en écriture
    public private(set) int $vues = 0;
    
    public function incrementerVues(): void
    {
        $this->vues++; // OK en interne
    }
}

$recette = new Recette();
echo $recette->vues; // OK : lecture publique
$recette->vues = 100; // ERREUR : écriture privée
```

**Utilité pour Les Restes :**
- Protéger les compteurs (vues, favoris)
- Sécuriser les dates de création
- Garantir l'intégrité des données

##### 1.3 DOM HTML5 Parser
Nouvelle classe `Dom\HTMLDocument` supportant nativement le HTML5.

**Avant (DOMDocument - HTML4) :**
```php
$dom = new DOMDocument();
@$dom->loadHTML($html); // @ pour masquer les warnings
```

**Après (Dom\HTMLDocument - HTML5) :**
```php
$dom = Dom\HTMLDocument::createFromString($html);
// Pas de warnings, support HTML5 complet
```

#### Impact sur le projet Les Restes

**Court terme (PHP 8.4 non requis) :**
- Le projet reste compatible PHP 8.3.28
- Monitoring de la sortie stable de PHP 8.4

**Moyen terme (migration envisagée) :**
- Refactoring des entités avec Property Hooks
- Utilisation d'Asymmetric Visibility pour la sécurité
- Migration estimée : 6-12 mois après la sortie stable

---

### 2. Symfony UX : Révolutionnez votre front-end

**Source** : [Axopen - Symfony UX](https://www.axopen.com/blog/2025/11/symfony-ux-revolutionnez-facilement-votrefront-end/)  
**Date** : Décembre 2025  
**Auteur** : Axopen Technical Team

#### Points clés de l'article

##### 2.1 Approche "HTML-centric"
L'écosystème Symfony UX (Turbo, Stimulus) permet de s'affranchir des builds complexes au profit d'une approche où le **serveur envoie du HTML prêt à l'emploi**.

**Avantages :**
- Pas de reconstruction frontend (JSON → HTML)
- SEO optimal (HTML rendu côté serveur)
- Accessibilité garantie par défaut
- Moins de JavaScript à maintenir

##### 2.2 Live Components
Composants réactifs sans JavaScript manuel.

**Exemple : Système de favoris refactoré**

**Actuellement (JavaScript Vanilla + AJAX) :**
```javascript
async function toggleFavori(recetteId) {
    const response = await fetch(`/favori/toggle/${recetteId}`, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const data = await response.json();
    // Mise à jour manuelle du DOM
    updateFavoriButton(data.isFavori, data.totalFavoris);
}
```

**Avec Live Components :**
```php
// src/Twig/Components/FavoriButton.php
#[AsLiveComponent('favori_button')]
class FavoriButton
{
    #[LiveProp(writable: true)]
    public Recette $recette;
    
    #[LiveAction]
    public function toggle(EntityManagerInterface $em): void
    {
        // Logique métier en PHP, pas en JS
        $favori = $em->getRepository(Favori::class)->findOneBy([
            'user' => $this->getUser(),
            'recette' => $this->recette
        ]);
        
        if ($favori) {
            $em->remove($favori);
        } else {
            $em->persist(new Favori($this->getUser(), $this->recette));
        }
        
        $em->flush();
    }
}
```

**Template Twig :**
```twig
<div {{ attributes }}>
    <button
        data-action="live#action"
        data-live-action-param="toggle"
    >
        {% if isFavori %}{% else %}{% endif %}
    </button>
</div>
```

**Résultat :**
- JavaScript supprimé (~50 lignes)
- Logique métier centralisée en PHP
- Synchronisation automatique de l'état

#### Plan d'intégration

**Phase 1 (Court terme - 3 mois) :**
- Migration du système de favoris vers Live Components
- Migration du système de commentaires

**Phase 2 (Moyen terme - 6 mois) :**
- Refactoring des formulaires dynamiques
- Ajout d'autocomplete sur ingrédients

---

### 3. RGAA 4.1.2 : Nouveautés Accessibilité 2025

**Source** : [Blaaaz - RGAA 4.1.2](https://www.blaaaz.com/mise-en-conformite-rgaa-4-1-2-en-2025-guide-completpour-un-site-accessible)  
**Date** : Août 2025  
**Auteur** : Blaaaz Accessibility Team

#### Nouveautés RGAA 4.1.2

##### 3.1 Focus visible obligatoire
Tous les éléments interactifs doivent avoir un **indicateur de focus clairement visible**.

**Norme :**
- Contraste minimum : **3:1** par rapport au fond
- Épaisseur minimum : **2px**

**Implémentation dans Les Restes :**
```css
/* public/css/utilities.css */
*:focus {
    outline: 2px solid #E76F51; /* Orange - contraste validé */
    outline-offset: 2px;
}

/* Jamais de outline: none ! */
button:focus,
a:focus,
input:focus {
    outline: 2px solid #E76F51;
}
```

##### 3.2 ARIA live regions
Meilleure gestion des mises à jour dynamiques pour les lecteurs d'écran.

**Messages flash accessibles :**
```twig
<div
    role="alert"
    aria-live="polite"
    aria-atomic="true"
    class="alert alert-success"
>
    {{ message }}
</div>
```

**Attributs :**
- `aria-live="polite"` : Annonce après la fin de la lecture en cours
- `aria-atomic="true"` : Lit l'intégralité du message
- `role="alert"` : Indique qu'il s'agit d'un message important

##### 3.3 Déclaration d'accessibilité obligatoire
À partir de 2025, tous les sites publics doivent publier une **déclaration d'accessibilité**.

**Contenu minimum :**
- État de conformité (totale, partielle, non conforme)
- Contenus non accessibles et justifications
- Coordonnées pour signaler un problème
- Date de réalisation de l'audit

#### Actions réalisées sur Les Restes

**Conformité actuelle :**
-  Scores Lighthouse Accessibilité : 86-100% (moyenne 96%)
-  Navigation clavier complète
-  Attributs ARIA sur éléments dynamiques
-  Contraste WCAG AA respecté

**À faire (Court terme) :**
- [ ] Créer une page `/accessibilite` avec déclaration
- [ ] Ajouter un lien "Signaler un problème d'accessibilité"
- [ ] Tester avec un vrai lecteur d'écran (NVDA/JAWS)

---

### 4. Performance Web : Core Web Vitals 2026

**Source** : [Google Web Vitals Update](https://web.dev/articles/vitals)  
**Date** : Janvier 2026

#### Nouvelles métriques

| Métrique | Description | Objectif | Les Restes |
|----------|-------------|----------|------------|
| **LCP** | Largest Contentful Paint | < 2.5s |  0.8s |
| **INP** | Interaction to Next Paint (remplace FID) | < 200ms | 120ms |
| **CLS** | Cumulative Layout Shift | < 0.1 |  0.02 |

#### Optimisations appliquées

**1. Lazy loading natif**
```html
<img src="recette.webp" alt="..." loading="lazy">
```

**2. Priorité de chargement**
```html
<link rel="preload" href="/css/base.css" as="style">
```

**3. Font display swap**
```css
@font-face {
    font-family: 'Bootstrap Icons';
    font-display: swap; /* Affiche texte pendant chargement */
    src: url('bootstrap-icons.woff2') format('woff2');
}
```

---

## Évolutions envisagées pour Les Restes

### Court terme (0-3 mois)

#### 1. Qualité de code et automatisation

**PHP-CS-Fixer** Priorité haute
```bash
# Installation
composer require --dev friendsofphp/php-cs-fixer

# Hook pre-commit
# Rejet automatique du code non conforme PSR-12
```

**PHPStan** Priorité moyenne
```bash
# Analyse statique niveau 6
vendor/bin/phpstan analyse src tests --level=6
```

**Tests PHPUnit** En cours
```
Couverture actuelle : ~30% (15 tests, 26 assertions)
Objectif : 60%+ (40 tests minimum)
```

#### 2. UX et accessibilité

**Symfony UX Autocomplete** Priorité haute
- Recherche d'ingrédients avec suggestions
- Remplacement de la sélection manuelle

**Déclaration RGAA** Priorité haute
- Page `/accessibilite` complète
- Formulaire de signalement

---

### Moyen terme (3-6 mois)

#### 1. Interactivité avancée

**Symfony Live Components** Recommandé
- Migration système de favoris
- Refactoring des commentaires
- Réduction JavaScript Vanilla (~70%)

**Symfony UX Chart.js** Nice to have
- Graphiques de répartition des notes
- Statistiques utilisateur (gaspillage évité)

#### 2. Performance et SEO

**Migration AVIF** Expérimental
```yaml
# config/packages/liip_imagine.yaml
recipe_thumbnail:
    format: avif # Gain supplémentaire -20% vs WebP
```

**Service Worker (PWA)** Objectif stratégique
- Mode hors-ligne pour recettes consultées
- Installation sur écran d'accueil mobile
- Cache intelligent des assets

---

### Long terme (6-12 mois)

#### 1. Infrastructure et déploiement

**CI/CD GitHub Actions** Essentiel
```yaml
# .github/workflows/deploy.yml
on: [push]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Run PHPUnit
        run: php bin/phpunit
      - name: Run PHPStan
        run: vendor/bin/phpstan analyse
```

**CDN Cloudflare** Optimisation
- Distribution assets géographiquement
- Réduction latence (-80%)
- Protection DDoS

#### 2. Features avancées

**API publique REST** Ouverture
- Endpoint `/api/recettes`
- Documentation OpenAPI/Swagger
- Rate limiting

**Recherche Elasticsearch/Meilisearch** Scalabilité
- Remplacement QueryBuilder pour gros volumes
- Recherche full-text performante
- Facettes et filtres avancés

---

##  Capitalisation des apprentissages

### Défis techniques résolus

#### 1. Formulaires dynamiques avec CollectionType

**Problème initial :**
Gestion simultanée de VichUploader (images) et CollectionType (ingrédients dynamiques).

**Solution mise en œuvre :**
- Isolation des mappings VichUploader
- Script JS avec regex pour gérer les index uniques
- Délégation d'événements pour performance

**Apprentissage :**
Maîtrise du `data-prototype` Symfony et manipulation avancée du DOM.

**Ressources utilisées :**
- [Symfony Docs - CollectionType](https://symfony.com/doc/current/form/form_collections.html)
- [Stack Overflow - VichUploader + CollectionType](https://stackoverflow.com/questions/tagged/vichuploaderbundle)

---

#### 2. Optimisation requêtes SQL (Problème N+1)

**Problème initial :**
100+ requêtes SQL sur page catalogue (1 requête par recette pour récupérer les commentaires).

**Détection :**
Profiler Symfony → Doctrine tab → 103 queries

**Solution mise en œuvre :**
```php
// RecetteRepository.php
public function findAllWithRelations(): array
{
    return $this->createQueryBuilder('r')
        ->leftJoin('r.commentaires', 'c')
        ->addSelect('c')
        ->leftJoin('r.user', 'u')
        ->addSelect('u')
        ->getQuery()
        ->getResult();
}
```

**Résultat :**
- Avant : 103 requêtes
- Après : 3 requêtes
- Temps de chargement : -1.8s

**Apprentissage :**
Importance de l'analyse systématique du Profiler avant optimisation.

---

#### 3. Scores Lighthouse - Accessibilité

**Problème initial :**
Score Accessibilité à 68% sur formulaire de création de recette.

**Causes identifiées :**
1. Labels manquants sur champs dynamiques
2. Boutons avec icône seule sans `aria-label`
3. Contraste insuffisant sur boutons `btn-warning`

**Corrections appliquées :**
```javascript
// public/js/recipe-form.js
function ajouterIngredient() {
    const newWidget = prototype.replace(/__name__/g, index);
    
    // Ajout aria-label sur boutons de suppression
    const deleteBtn = newWidget.querySelector('.remove-ingredient');
    deleteBtn.setAttribute('aria-label', `Supprimer l'ingrédient ${index + 1}`);
    
    index++;
}
```

**Résultat :**
- Avant : 68%
- Après : 86%

**Apprentissage :**
L'accessibilité n'est pas une option mais une responsabilité.

---

### Évolution de ma méthodologie

#### Avant le projet
- Recherche de solutions sur Stack Overflow
- Copy-paste de code sans compréhension
- Tests manuels uniquement

#### Pendant le projet
- Consultation systématique de la documentation officielle
- Analyse des logs (Profiler Symfony) avant modification
- Expérimentation en bac à sable

#### Après le projet
- Veille structurée (newsletters, blogs)
- Tests automatisés (PHPUnit)
- Contribution à la communauté (partage des solutions)

---

## Plan de veille continue

### Routine hebdomadaire

**Lundi matin (30 min) :**
- Lecture newsletters (PHP Weekly, Symfony Station)
- Vérification changelogs Symfony/PHP

**Mercredi soir (1h) :**
- Lecture 2-3 articles techniques (DEV.to, CSS-Tricks)
- Sauvegarde des ressources intéressantes (favoris, notes)

**Vendredi après-midi (1-2h) :**
- Expérimentation d'un nouveau bundle/outil en bac à sable
- Mise à jour de la documentation de veille

### Routine mensuelle

**1 samedi par mois (3-4h) :**
- Test approfondi d'une nouvelle technologie
- Création d'un projet minimal pour comprendre
- Rédaction d'une fiche de synthèse

### Organisation des ressources

**Structure de favoris :**
```
Veille Technique/
├── Symfony/
│   ├── Bundles
│   ├── Best Practices
│   └── Versions
├── PHP/
│   ├── PHP 8.3
│   ├── PHP 8.4
│   └── Design Patterns
├── Frontend/
│   ├── JavaScript Vanilla
│   ├── CSS/SCSS
│   └── Accessibilité
├── Base de données/
│   ├── MySQL Optimisation
│   └── Doctrine ORM
└── DevOps/
    ├── Git
    ├── CI/CD
    └── Déploiement
```

**Outil de gestion :**
- Notion (pour la prise de notes structurée)
- Feedly (agrégateur de flux RSS)
- Pocket (sauvegarde d'articles à lire)

---

##  Indicateurs de suivi

### Métriques de veille

| Indicateur | Objectif mensuel | Réalisé (Fév 2026) |
|------------|------------------|---------------------|
| Articles lus | 15 | 18 |
| Newsletters consultées | 12 | 12 |
| Bundles testés | 2 | 1 |
| Commits apprentissage | 5 | 7 |

### ROI de la veille

**Temps investi :** ~8h/mois  
**Gains mesurables :**
- Migration Webpack → AssetMapper : +25% performance
- Optimisation SQL (N+1) : -1.8s temps de chargement
- LiipImagine : -30% poids images

**Gains qualitatifs :**
- Veille proactive sur dépréciations PHP/Symfony
- Anticipation des migrations (PHP 8.4, Symfony 8.x)
- Montée en compétence continue

---

##  Conclusion

La veille technologique n'est pas une activité passive mais un **investissement stratégique** pour :

1. **Rester employable** : Marché du travail exigeant
2. **Produire de la qualité** : Standards évolutifs
3. **Anticiper les migrations** : Éviter la dette technique
4. **Se former en continu** : Apprentissage permanent

**Principe directeur :**  
> "Lire la documentation officielle avant de chercher une solution externe"

Cette approche garantit :
- Solutions à jour et officielles
- Compréhension profonde des outils
- Code maintenable et évolutif

---

##  Ressources complémentaires

### Liens utiles

- [Awesome Symfony](https://github.com/sitepoint-editors/awesome-symfony) - Bundles et ressources
- [PHP The Right Way](https://phptherightway.com/) - Best practices PHP
- [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html) - Standards Symfony
- [Web.dev](https://web.dev/) - Performance et accessibilité

### Comptes à suivre

**Twitter/X :**
- @symfony
- @fabpot (Fabien Potencier)
- @nikita_ppv (PHP Core Developer)

**YouTube :**
- Symfony Casts
- Grafikart
- Traversy Media (JavaScript/Frontend)

---

**Document créé dans le cadre du Titre Professionnel DWWM - DAWAN Toulouse - Mars 2026**
