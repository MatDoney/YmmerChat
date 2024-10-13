
# YmmerChat

YmmerChat est une application de chat simple et fonctionnelle développée en PHP 8 avec une base de données MySQL. Ce projet utilise une architecture MVC et intègre des appels API via JavaScript. Il a été réalisé dans le cadre des Ymmersion de Ynov Aix-En-Provence par :
 - DONEY Matthis 
 - CISSÉ Maryam
 - EL MOKRETAR Ahlem
 - RIEHL Alan

## Prérequis

-   **PHP** (version 8 ou supérieure)
-   **MySQL**
-   Serveur local comme **WAMP** ou **XAMPP**
-   Outil de gestion de base de données tel que **MySQL Workbench**, **DBeaver**, ou **phpMyAdmin**

## Installation

### 1. Cloner le dépôt

Commence par cloner le dépôt GitHub du projet sur ta machine locale.

`git clone https://github.com/MatDoney/YmmerChat.git` 

### 2. Créer un VirtualHost avec WAMP

Pour faire fonctionner le projet localement, il est nécessaire de configurer un VirtualHost sur ton serveur local (WAMP).

#### a. Lancer WAMP

1.  Assure-toi que **WAMP** est bien installé sur ton ordinateur.
2.  Démarre **WAMP** en cliquant sur son icône.
3.  Vérifie que l'icône WAMP dans la barre des tâches est verte.

#### b. Accéder à l'interface de gestion de WAMP

1.  Clique **gauche** sur l'icône WAMP dans la barre des tâches.
2.  Dans le menu qui s'ouvre, va dans **Outils**.
3.  Choisis l'option **Ajouter un VirtualHost**.

#### c. Créer un VirtualHost via l'interface

1.  Remplis les champs comme suit :
    
    -   **Nom du VirtualHost** : `ymmerchat.local`
    -   **Chemin d'accès au projet** : `C:/wamp64/www/ymmerchat`
2.  Clique sur **Valider** ou **Créer le VirtualHost** pour appliquer les changements.
    


    

### d. Redémarrer WAMP

1.  Clique **gauche** sur l'icône WAMP, puis choisis **Redémarrer tous les services**.

### 3. Importer la base de données

1.  Dans le dossier du projet, accède au répertoire `bdd` et localise le fichier `YmmerChatbase.sql`.
2.  Ouvre ton outil de gestion de base de données (MySQL Workbench, DBeaver, ou phpMyAdmin).
3.  Importe le fichier `YmmerChatbase.sql` qui créera la base de donnée et l'utilisateur.

### 4. Accéder à l'application

Une fois que la base de données est importée et le VirtualHost configuré, ouvre ton navigateur et accède à l'URL suivante :

`http://ymmerchat.local` 

### 5. Créer un compte

Sur la page d'accueil, crée un compte en te rendant sur la page d'inscription, puis connecte-toi pour commencer à utiliser l'application.

## Fonctionnalités du site

L'application YmmerChat inclut les pages suivantes :

### 1. Page de login

_Espace pour insérer une image de la page de login._

### 2. Page d'inscription

_Espace pour insérer une image de la page d'inscription._

### 3. Page d'accueil avec les différentes conversations

_Espace pour insérer une image de la page d'accueil._

### 4. Page de chat

_Espace pour insérer une image de la page de chat._

### 5. Page de modification de l'utilisateur

_Espace pour insérer une image de la page de modification de l'utilisateur._

### 6. Page de création de conversation

_Espace pour insérer une image de la page de création de conversation._

## Structure du projet

-   **Modèle MVC** : Le projet est organisé selon un modèle MVC (Modèle - Vue - Contrôleur).
-   **Routage API** : Les routes API sont définies dans le répertoire `/model/api` et sont appelées via JavaScript pour gérer les interactions avec le backend.
-   **Logique d'application** : Toutes les méthodes utilitaires et les interactions avec la base de données sont centralisées dans le répertoire `Model`.
-   **Contrôleurs** : Les pages principales de l'application sont gérées dans le répertoire `Controller`.
-   **Vues** : Le fichier `header` ainsi que les autres vues sont dans le répertoire `View`.
