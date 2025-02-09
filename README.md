# Cahier des Charges - Système de Réservation de Tickets de Voyage

## 1. Introduction
Ce document décrit les spécifications techniques et fonctionnelles d'un système de réservation de tickets de voyage en ligne. Il couvre les aspects de conception, de gestion des utilisateurs, des voyages, des réservations et des paiements.

## 2. Objectifs du Projet
- Permettre aux utilisateurs de consulter et réserver des billets de voyage en ligne.
- Gérer les paiements de manière sécurisée.
- Offrir une interface simple et intuitive.

## 3. Fonctionnalités
### 3.1 Gestion des Utilisateurs
- Inscription et connexion des utilisateurs.
- Gestion des informations personnelles (nom, email, téléphone, mot de passe).

### 3.2 Gestion des Voyages
- Ajout, modification et suppression des voyages.
- Affichage des détails du voyage (destination, date, heure, prix, places disponibles).

### 3.3 Gestion des Réservations
- Possibilité pour un utilisateur de réserver un voyage.
- Consultation des réservations effectuées.
- Annulation d'une réservation.

### 3.4 Gestion des Paiements
- Paiement en ligne via Visa, MasterCard et Mobile Money.
- Historique des paiements effectués.

## 4. Technologies Utilisées
- **Backend** : PHP avec MySQL
- **Frontend** : HTML, CSS, JavaScript
- **Base de données** : MySQL

## 5. Contraintes Techniques
- Responsive Design (adapté aux mobiles et tablettes).
- Interface utilisateur intuitive.
- Système de sécurité pour les paiements.

## 6. Acteurs du Système
- **Administrateur** : Gestion des voyages et des utilisateurs.
- **Utilisateur** : Consultation et réservation des billets.

## 7. Modèle de Données
Les tables principales sont :
- **utilisateurs** (id, nom, email, mot_de_passe, téléphone, date_inscription)
- **voyages** (id, destination, date_depart, heure_depart, prix, places_disponibles)
- **reservations** (id, utilisateur_id, voyage_id, statut, date_reservation)
- **paiements** (id, reservation_id, montant, mode_paiement, date_paiement)
- **itineraires** (id, voyage_id, description)

## 8. Conclusion
Ce cahier des charges sert de guide pour le développement du système et assure que toutes les fonctionnalités requises sont bien implémentées.

