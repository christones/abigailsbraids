# Abigail's Braids

Site vitrine et système de réservation pour **Abigail's Braids**, salon de tresses et
nattes africaines à Strasbourg. Construit avec [Laravel](https://laravel.com), Tailwind
CSS et [Swiper.js](https://swiperjs.com) pour les carrousels.

## Fonctionnalités

- Page d'accueil avec carrousel (hero slider), présentation des prestations, galerie et avis clients.
- Pages Prestations, Galerie, À propos, Contact.
- Formulaire de réservation en ligne ouvert à toutes les femmes (`/reservation`) avec
  validation des champs, créneaux horaires et page de confirmation.
- Espace salon protégé (`/connexion`, `/admin`) pour consulter, filtrer, mettre à jour le
  statut et supprimer les réservations reçues.
- Suite de tests automatisés (PHPUnit) couvrant les pages publiques, le formulaire de
  réservation et l'espace admin.

## Démarrage local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # base SQLite locale
php artisan migrate --seed
npm install
npm run build   # ou `npm run dev` pendant le développement
php artisan serve
```

Le seeder crée automatiquement :

- un jeu de prestations réalistes (box braids, knotless, vanilles, cornrows, faux locs...) ;
- un compte administrateur pour l'espace salon, à partir des variables d'environnement
  `ADMIN_EMAIL` / `ADMIN_PASSWORD` (par défaut `admin@abigailsbraids.fr` / `password`
  en local — **à changer avant toute mise en production**).

## À personnaliser avant la mise en ligne

Ce dépôt contient un contenu de démarrage réaliste mais **à vérifier avec la salonnière**
avant publication :

- Coordonnées (adresse exacte, téléphone, e-mail, horaires) dans `resources/views/partials/footer.blade.php`
  et `resources/views/contact.blade.php`.
- Photos : les visuels du site sont des images de substitution générées (`placehold.co`)
  à remplacer par de vraies photos du salon et des réalisations.
- Tarifs et durées des prestations dans `database/seeders/ServiceSeeder.php`.
- Identifiants administrateur (`ADMIN_EMAIL` / `ADMIN_PASSWORD` dans `.env`).

## Tests

```bash
php artisan test
```

## Workflow Git & déploiement

- Le développement se fait sur la branche `dev`.
- Chaque push sur `dev` déclenche la CI (tests + build des assets) puis, si elle passe,
  ouvre automatiquement (ou met à jour) une pull request `dev` → `main` avec fusion
  automatique dès que les vérifications sont au vert. Voir `.github/workflows/`.
- La branche `main` reflète donc toujours la dernière version validée du site.
