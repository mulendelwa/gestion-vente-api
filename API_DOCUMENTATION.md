# 📘 Documentation Technique API - Gestion de Vente

## 🌐 Informations Générales
- **URL de Base** : `http://127.0.0.1:8080/api`
- **Format** : JSON
- **Authentification** : Bearer Token (Laravel Sanctum)
- **Headers Requis** :
  - `Accept: application/json`
  - `Content-Type: application/json`
  - `Authorization: Bearer {votre_token}` (pour les routes protégées)

---

## 1. 🔐 Authentification & Utilisateurs

### Inscription (Register)
Créer un nouvel utilisateur administrateur ou vendeur.
- **Méthode** : `POST`
- **URL** : `/register`
- **Body** :
  ```json
  {
    "name": "Admin",
    "email": "admin@example.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```

### Connexion (Login)
Récupérer le token d'accès nécessaire pour toutes les autres requêtes.
- **Méthode** : `POST`
- **URL** : `/login`
- **Body** :
  ```json
  {
    "email": "admin@example.com",
    "password": "password"
  }
  ```
- **Réponse** : Copiez le champ `access_token`.

### Déconnexion (Logout)
Invalider le token actuel.
- **Méthode** : `POST`
- **URL** : `/logout`

### Profil Utilisateur
- **Méthode** : `GET`
- **URL** : `/user`

### Liste des Utilisateurs
- **Méthode** : `GET`
- **URL** : `/users`

---

## 2. 📦 Produits (Stock)

### Lister les produits
- **Méthode** : `GET`
- **URL** : `/produits`

### Créer un produit
- **Méthode** : `POST`
- **URL** : `/produits`
- **Body** :
  ```json
  {
    "nom": "Ordinateur Portable",
    "description": "Dell XPS 15",
    "prix": 1200.50,
    "quantite_stock": 10
  }
  ```

### Voir/Modifier/Supprimer
- **Voir** : `GET /produits/{id}`
- **Modifier** : `PUT /produits/{id}`
- **Supprimer** : `DELETE /produits/{id}`

---

## 3. 👥 Clients

### Lister les clients
- **Méthode** : `GET`
- **URL** : `/clients`

### Créer un client
- **Méthode** : `POST`
- **URL** : `/clients`
- **Body** :
  ```json
  {
    "nom": "Jean Dupont",
    "email": "jean@gmail.com",
    "telephone": "0601020304",
    "adresse": "123 Rue Principale"
  }
  ```

### Voir/Modifier/Supprimer
- **Voir** : `GET /clients/{id}`
- **Modifier** : `PUT /clients/{id}`
- **Supprimer** : `DELETE /clients/{id}`

---

## 4. 💰 Ventes (Facturation)

Cette partie gère la transaction globale et ses lignes de produits.

### Lister les ventes
- **Méthode** : `GET`
- **URL** : `/ventes`

### Créer une vente (Transaction Complète)
Cette requête crée la vente ET insère toutes les lignes de produits en une seule fois.
- **Méthode** : `POST`
- **URL** : `/ventes`
- **Body** :
  ```json
  {
    "utilisateur_id": 1,
    "client_id": 1,
    "montant_total": 2401.00,
    "lignes": [
      {
        "produit_id": 1,
        "quantite": 2,
        "prix_unitaire": 1200.50
      }
    ]
  }
  ```

### Voir une vente
Affiche les détails de la vente, le client associé et les produits achetés.
- **Méthode** : `GET`
- **URL** : `/ventes/{id}`

---

## 5. 💳 Paiements (Encaissements)

Gère les règlements associés à une vente.

### Enregistrer un paiement
- **Méthode** : `POST`
- **URL** : `/paiements`
- **Règle** : Le montant ne doit pas dépasser le "reste à payer" de la vente.
- **Body** :
  ```json
  {
    "vente_id": 1,
    "montant": 500.00,
    "mode_paiement": "espece", 
    "reference": "OPTIONAL_REF"
  }
  ```
  *Modes acceptés (exemples)* : `espece`, `carte`, `mobile_money`, `cheque`.

### Lister les paiements
- **Méthode** : `GET`
- **URL** : `/paiements`

---

## 🗄️ Structure de la Base de Données

1.  **users** : Utilisateurs du système (Vendeurs, Admins).
2.  **clients** : Clients finaux.
3.  **produits** : Catalogue des articles.
4.  **ventes** : Entête de la facture (Lié à User et Client).
5.  **lignes_ventes** : Détails de la facture (Produit, Quantité, Prix).
6.  **paiements** : Historique des encaissements (Lié à Vente).
