# Installation détaillée de WellBot

Ce guide reprend pas à pas ce que résume le [README](README.md), et ajoute
l'option MySQL ainsi que les problèmes les plus courants.

Prérequis : **PHP 8.1 ou plus** et **Composer**.
Vérifier avec `php -v` et `composer -V`.

---

## 1. Installer les dépendances

```bash
composer install
```

## 2. Créer le fichier de configuration

```bash
cp .env.example .env        # Windows : copy .env.example .env
php artisan key:generate
```

`key:generate` remplit `APP_KEY`, qui sert à chiffrer les sessions et les
cookies. Sans cette clé, l'application refuse de démarrer.

## 3. Préparer la base de données

### Option A — SQLite (recommandé, zéro installation)

Le fichier doit simplement exister :

```bash
type nul > database\database.sqlite      # Windows
touch database/database.sqlite           # Linux / macOS
```

Rien d'autre à configurer : `.env.example` utilise déjà `DB_CONNECTION=sqlite`.

### Option B — MySQL via phpMyAdmin (XAMPP / WAMP)

1. Démarrer Apache et MySQL depuis le panneau XAMPP ou WAMP.
2. Ouvrir phpMyAdmin et créer une base nommée `bien_etre_etudiant`.
3. Dans `.env`, commenter la ligne SQLite et décommenter le bloc MySQL :

```env
# DB_CONNECTION=sqlite

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bien_etre_etudiant
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Créer les tables et les données de départ

```bash
php artisan migrate --seed
```

Cette commande crée les cinq tables du projet et insère :

- un **compte administrateur** — `admin@bienetre.tn` / `admin123`
- une série de **ressources** de bien-être
- une série de **mots-clés** pour le chatbot

## 5. Activer l'IA du chatbot *(facultatif)*

1. Aller sur <https://aistudio.google.com/app/apikey>.
2. Se connecter avec un compte Google, puis cliquer sur **Create API Key**.
3. Coller la clé dans `.env` :

```env
GEMINI_API_KEY=votre_cle_ici
```

Cette étape peut être sautée sans conséquence : WellBot répond alors à partir
des mots-clés gérés dans l'espace administrateur.

## 6. Lancer le serveur

```bash
php artisan serve
```

Ouvrir <http://localhost:8000>.

---

## En cas de problème

| Symptôme | Cause probable | Solution |
|---|---|---|
| `No application encryption key has been specified` | `APP_KEY` vide | `php artisan key:generate` |
| `database file does not exist` | Fichier SQLite absent | Refaire l'étape 3 |
| Page **« Votre session a expiré »** (419) | Onglet resté ouvert pendant un redémarrage du serveur | Recharger la page de connexion |
| Modifications invisibles après édition | Caches Laravel | `php artisan config:clear && php artisan route:clear && php artisan view:clear` |
| Le chatbot répond toujours pareil | Pas de clé Gemini | Normal : mode mots-clés (étape 5 pour l'activer) |
| `SQLSTATE[HY000] [1049] Unknown database` | Base MySQL non créée | Refaire l'étape 3, option B |

## Commandes utiles

```bash
php artisan route:list          # toutes les routes et leurs permissions
php artisan migrate:fresh --seed  # remet la base à zéro (efface les données)
php artisan tinker              # console interactive
```
