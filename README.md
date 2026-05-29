# MyNumber — Mastermind 2 joueurs

Jeu de déduction en ligne à deux joueurs. Un joueur crée une partie et partage un lien d'invitation. Chacun choisit une combinaison secrète de 4 chiffres, puis les joueurs s'affrontent au tour par tour pour deviner la combinaison adverse.

---

## Prérequis

Avant de démarrer, vérifie que tu as installé :

- **PHP** >= 8.2
- **Composer**
- **Node.js** >= 18 + **npm**
- **MariaDB** (ou MySQL)

---

## Installation

### 1. Cloner le projet

```bash
git clone <url-du-repo> MyNumber
cd MyNumber
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configurer l'environnement

Copie le fichier `.env.example` en `.env` :

```bash
cp .env.example .env
```

Génère la clé d'application :

```bash
php artisan key:generate
```

### 5. Configurer la base de données

Ouvre le fichier `.env` et renseigne tes informations MariaDB :

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mynumber
DB_USERNAME=root
DB_PASSWORD=ton_mot_de_passe
```

Crée ensuite la base de données dans MariaDB :

```sql
CREATE DATABASE mynumber CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Lancer les migrations

```bash
php artisan migrate
```

Cela crée les 4 tables : `users`, `parties`, `combinaison_secret`, `proposition`.

---

## Démarrage

Il faut lancer **deux terminaux en parallèle** :

**Terminal 1 — Serveur PHP**
```bash
php artisan serve
```
L'application est accessible sur [http://localhost:8000](http://localhost:8000)

**Terminal 2 — Compilation des assets (Tailwind + Vite)**
```bash
npm run dev
```

> Sans `npm run dev`, la mise en page n'apparaît pas (pas de CSS).

---

## Utilisation

### Créer une partie

1. Inscris-toi sur `/register`
2. Connecte-toi sur `/login`
3. Clique sur **Créer une partie** sur la page d'accueil
4. Copie le lien d'invitation et envoie-le à ton adversaire

### Rejoindre une partie

1. Connecte-toi avec un autre compte
2. Ouvre le lien d'invitation reçu
3. Clique sur **Rejoindre la partie**

### Déroulement

| Étape | Description |
|---|---|
| `en_attente` | Le créateur attend que l'adversaire rejoigne via le lien |
| `preparation` | Chaque joueur choisit sa combinaison secrète de 4 chiffres |
| `en_cours` | Les joueurs jouent chacun leur tour en proposant une combinaison |
| `terminee` | Le premier à trouver la combinaison exacte gagne |

### Règles

- La combinaison est composée de **4 chiffres** (0–9), ex : `0391`
- Un chiffre peut être répété
- Après chaque proposition, tu vois combien de chiffres de ta tentative **sont présents** dans le secret (peu importe la position)
- Tu gagnes quand ta proposition est **exactement identique** au secret

---

## Structure du projet

```
app/
├── Http/Controllers/
│   ├── Auth/                  # Connexion, inscription
│   ├── PartieController.php   # Logique du jeu
│   └── HomeController.php
├── Models/
│   ├── User.php
│   ├── Partie.php
│   ├── CombinaisonSecret.php
│   └── Proposition.php
database/
└── migrations/                # 4 tables : users, parties, combinaison_secret, proposition
resources/views/
├── home/home.blade.php        # Page d'accueil
├── game/afficher.blade.php    # Page de la partie
├── auth/login.blade.php
└── auth/register.blade.php
routes/
├── web.php                    # Routes principales + jeu
└── auth.php                   # Routes connexion/inscription
```

---

## Commandes utiles

```bash
# Remettre la base de données à zéro (supprime toutes les données)
php artisan migrate:fresh

# Voir toutes les routes disponibles
php artisan route:list

# Vider le cache
php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

---

## Stack technique

| Outil | Rôle |
|---|---|
| Laravel 11 | Framework PHP |
| PHP 8.5 | Langage backend |
| MariaDB | Base de données |
| Tailwind CSS 4 | Styles |
| Vite 8 | Bundler assets |
| Alpine.js 3 | JS léger côté client |
