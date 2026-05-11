# Mise en route du projet "Bien-etre Etudiant"

## 1. Installer les dependances Laravel
```
composer install
```

## 2. Generer la cle d'application
```
php artisan key:generate
```

## 3. Creer la base de donnees

### Option A : SQLite (le plus simple)
Le fichier `database/database.sqlite` doit exister :
```
type nul > database\database.sqlite
```
(sur Linux/Mac : `touch database/database.sqlite`)

### Option B : MySQL via phpMyAdmin
1. Ouvrir phpMyAdmin (XAMPP/WAMP)
2. Creer une base nommee `bien_etre_etudiant`
3. Modifier `.env` : decommenter les lignes `DB_CONNECTION=mysql` et commenter `DB_CONNECTION=sqlite`

## 4. Lancer les migrations + seeders
```
php artisan migrate --seed
```

Cela cree toutes les tables ET un compte admin par defaut :
- Email    : admin@bienetre.tn
- Mot de passe : admin123

## 5. (Optionnel) Activer l'IA du chatbot
1. Aller sur https://aistudio.google.com/app/apikey
2. Se connecter avec un compte Google
3. Cliquer sur "Create API Key"
4. Coller la cle dans `.env` :
```
GEMINI_API_KEY=ta_cle_ici
```
Si tu sautes cette etape, le chatbot fonctionne quand meme avec les mots cles.

## 6. Lancer le serveur
```
php artisan serve
```
Ouvrir http://localhost:8000 dans le navigateur.

## 7. Initialiser Git (a faire avant la presentation)
```
git init
git add .
git commit -m "Premier commit : projet bien-etre etudiant"
```
Puis creer un repo sur GitHub et pousser :
```
git remote add origin https://github.com/TON_PSEUDO/bien-etre-etudiant.git
git branch -M main
git push -u origin main
```

## Documents fournis (dossier docs/)
- `Cahier_des_charges.docx` : a presenter avec les diagrammes UML
- `Comment_pitcher_le_projet.docx` : guide complet de la presentation orale
- `diagramme_admin.svg` : diagramme de cas d'utilisation administrateur
- `schema_base_de_donnees.svg` : schema MLD de la base
