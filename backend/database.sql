-- Base de données Tatienounou
CREATE DATABASE IF NOT EXISTS tatienounou DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tatienounou;

-- Table des utilisateurs
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nom VARCHAR(100),
  prenom VARCHAR(100),
  role ENUM('PARENT', 'PRO', 'ADMIN') NOT NULL DEFAULT 'PARENT',
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des demandes de garde
CREATE TABLE requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent_id INT NOT NULL,
  titre VARCHAR(255),
  description TEXT,
  date_debut DATE,
  date_fin DATE,
  statut ENUM('EN_ATTENTE', 'ACCEPTEE', 'REFUSEE', 'SUPPRIMEE') DEFAULT 'EN_ATTENTE',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des abonnements (pour pros)
CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pro_id INT NOT NULL,
  is_active BOOLEAN DEFAULT 0,
  start_date DATE,
  end_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pro_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des messages (optionnel)
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (receiver_id) REFERENCES users(id)
);
