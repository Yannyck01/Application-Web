# 🎮 SAE 2-01 - PHP - Développement d’une application
### WAYMEL Raphaël (waym0002) - DJO-DJOLO AYESSA Yannyck (djo-0001)

---

## 🚀 Installation / Mise en place

### 1. Cloner le projet

```bash
git clone https://iut-info.univ-reims.fr/gitlab/waym0002/sae2-01/
cd sae2-01
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Créer le fichier `.mypdo.ini`

```ini
[mypdo]
dsn = "mysql:host=mysql;dbname=<?>;charset=utf8"
username = "<?>"
password = "<?>"
```
_🔒 Ne versionnez jamais ce fichier (il est déjà dans le .gitignore)._

### 🚨🚨🚨 Sous Windows, prenez le soin de vérifier ces paramètres pour le bon fonctionnement du projet:

* Ajoutez git à votre variable d'environnement PATH, pour ce faire:
    * Tapez __variable d'environnement__ dans la barre de recherche windows et cliquez dessus.
    * Dans la fenêtre qui s'ouvre cliquez sur __variable d'environnement__
    * cliquez sur la variable __path__ puis sur modifier
    * Enfin, ajoutez le chemin qui mène vers votre __git.exe__
* Dans votre fichier __php.ini__, activez les extensions nécéssaires à l'installation de composer et l'utilisation de pdo_mysql:
    * Faites un `CTRL+F` puis cherchez `;extension=pdo_mysql` puis retirez le point virgule (;).
    * Faites de même pour `;extension=zip`, sauvegardez les modifications.
* Installez `composer` avec la commande `composer install`.

#### 👍 Vous êtes maintenant prêt à tester le projet.

---

## ▶️ Lancer le serveur local

### Sous Linux :

````bash
composer start:linux
````

### Sous Windows :

````bash
composer start:windows
````

_Ces commandes utilisent les scripts définis dans le fichier `composer.json`._

---

## 📦 Structure du projet

````mathematica
public/                 → Point d'entrée HTTP (index.php, genre.php, etc.)
  └── admin/            → game-form.php, game-delete.php, etc.
  └── css/              → style.css
  └── img/              → Icones
src/
  └── Database/         → MyPdo.php
  └── Entity/           → Entités comme Game, Genre, Poster, etc.
       └── Collection/  → CategoryCollection.php, etc.
       └── Exception/   → EntityNotFoundException.php
       └── Form/        → Génération du formulaires HTML
  └── Exception/        → ParameterException.php
  └── Html/             → WebPage.php
vendor/                 → Dépendances installées via Composer
.mypdo.ini              → Configuration privée de la base de données
````
---

## ✅ Prérequis

 * PHP ≥ 8.0
 * Composer
 * Navigateur web moderne
