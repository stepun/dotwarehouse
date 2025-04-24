<?php

declare(strict_types=1);

namespace Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424131649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // OAuth таблицы
        $this->addSql('CREATE TABLE oauth_access_tokens (
            access_token VARCHAR(40) NOT NULL PRIMARY KEY,
            client_id VARCHAR(80) NOT NULL,
            user_id VARCHAR(255) DEFAULT NULL,
            expires TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            scope VARCHAR(2000) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_authorization_codes (
            authorization_code VARCHAR(40) NOT NULL PRIMARY KEY,
            client_id VARCHAR(80) NOT NULL,
            user_id VARCHAR(255) DEFAULT NULL,
            redirect_uri VARCHAR(2000) DEFAULT NULL,
            expires TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            scope VARCHAR(2000) DEFAULT NULL,
            id_token VARCHAR(2000) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_clients (
            client_id VARCHAR(80) NOT NULL PRIMARY KEY,
            client_secret VARCHAR(80) NOT NULL,
            redirect_uri VARCHAR(2000) NOT NULL,
            grant_types VARCHAR(80) DEFAULT NULL,
            scope VARCHAR(2000) DEFAULT NULL,
            user_id VARCHAR(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_jwt (
            client_id VARCHAR(80) NOT NULL PRIMARY KEY,
            subject VARCHAR(80) DEFAULT NULL,
            public_key VARCHAR(2000) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_refresh_tokens (
            refresh_token VARCHAR(40) NOT NULL PRIMARY KEY,
            client_id VARCHAR(80) NOT NULL,
            user_id VARCHAR(255) DEFAULT NULL,
            expires TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            scope VARCHAR(2000) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_scopes (
            type VARCHAR(255) NOT NULL DEFAULT "supported",
            scope VARCHAR(2000) DEFAULT NULL,
            client_id VARCHAR(80) DEFAULT NULL,
            is_default SMALLINT DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        $this->addSql('CREATE TABLE oauth_users (
            username VARCHAR(255) NOT NULL PRIMARY KEY,
            password VARCHAR(2000) DEFAULT NULL,
            first_name VARCHAR(255) DEFAULT NULL,
            last_name VARCHAR(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3');

        // Основные таблицы
        $this->addSql('CREATE TABLE warehouse_account (
            id INT AUTO_INCREMENT PRIMARY KEY,
            account_identifier VARCHAR(255) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY account_identifier (account_identifier)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            warehouse_account_id INT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY email (email),
            CONSTRAINT users_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE warehouses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(255) DEFAULT NULL,
            identifier VARCHAR(255) DEFAULT NULL,
            warehouse_account_id INT DEFAULT NULL,
            user_id INT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY identifier (identifier),
            CONSTRAINT warehouses_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id),
            CONSTRAINT warehouses_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE nomenclature (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(255) DEFAULT NULL,
            measure VARCHAR(255) DEFAULT NULL,
            article VARCHAR(255) DEFAULT NULL,
            manufacturer VARCHAR(255) DEFAULT NULL,
            warehouse_account_id INT DEFAULT NULL,
            user_id INT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT nomenclature_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id),
            CONSTRAINT nomenclature_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE operation_types (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            operation_type TINYINT(1) UNSIGNED NOT NULL DEFAULT 1
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE stock_entries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nomenclature_id INT DEFAULT NULL,
            warehouse_id INT DEFAULT NULL,
            initial_price DECIMAL(10,2) DEFAULT NULL,
            sell_price DECIMAL(10,2) DEFAULT NULL,
            warehouse_account_id INT DEFAULT NULL,
            user_id INT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT stock_entries_ibfk_1 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id),
            CONSTRAINT stock_entries_ibfk_2 FOREIGN KEY (warehouse_id) REFERENCES warehouses (id),
            CONSTRAINT stock_entries_ibfk_3 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id),
            CONSTRAINT stock_entries_ibfk_4 FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE stock_movements (
            id INT AUTO_INCREMENT PRIMARY KEY,
            document_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            document_number VARCHAR(255) DEFAULT NULL,
            price DECIMAL(10,2) DEFAULT NULL,
            operation_type_id INT DEFAULT NULL,
            nomenclature_id INT DEFAULT NULL,
            warehouse_id INT DEFAULT NULL,
            quantity INT DEFAULT NULL,
            warehouse_account_id INT DEFAULT NULL,
            user_id INT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT stock_movements_ibfk_1 FOREIGN KEY (operation_type_id) REFERENCES operation_types (id),
            CONSTRAINT stock_movements_ibfk_2 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id),
            CONSTRAINT stock_movements_ibfk_3 FOREIGN KEY (warehouse_id) REFERENCES warehouses (id),
            CONSTRAINT stock_movements_ibfk_4 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id),
            CONSTRAINT stock_movements_ibfk_5 FOREIGN KEY (user_id) REFERENCES users (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE sale_prices (
            id INT AUTO_INCREMENT PRIMARY KEY COMMENT "Уникальный идентификатор записи",
            warehouse_account_id INT NOT NULL,
            user_id INT NOT NULL,
            nomenclature_id INT NOT NULL,
            price_list_name VARCHAR(255) NOT NULL,
            original_price DECIMAL(10,2) NOT NULL,
            sell_price DECIMAL(10,2) NOT NULL,
            start_date DATETIME NOT NULL,
            end_date DATETIME DEFAULT NULL,
            discount DECIMAL(5,2) DEFAULT 0.00,
            discounted_price DECIMAL(10,2) DEFAULT NULL,
            vat_rate DECIMAL(10,2) NOT NULL,
            vat_amount DECIMAL(10,2) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT sale_prices_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id),
            CONSTRAINT sale_prices_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id),
            CONSTRAINT sale_prices_ibfk_3 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        // Добавление тестового клиента OAuth
        $this->addSql('INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES
            ("testclient", "$2y$14$KlbNZsa25AL7wp81UDPqxOJ4Ai7lAjyPZdvlkOA8EWSNy50MKngLG", "/oauth/receivecode")');

    }

    public function down(Schema $schema): void
    {
        // Удаление в обратном порядке из-за внешних ключей
        $this->addSql('DROP TABLE IF EXISTS sale_prices');
        $this->addSql('DROP TABLE IF EXISTS stock_movements');
        $this->addSql('DROP TABLE IF EXISTS stock_entries');
        $this->addSql('DROP TABLE IF EXISTS nomenclature');
        $this->addSql('DROP TABLE IF EXISTS warehouses');
        $this->addSql('DROP TABLE IF EXISTS users');
        $this->addSql('DROP TABLE IF EXISTS warehouse_account');
        $this->addSql('DROP TABLE IF EXISTS operation_types');

        // Удаление OAuth таблиц
        $this->addSql('DROP TABLE IF EXISTS oauth_access_tokens');
        $this->addSql('DROP TABLE IF EXISTS oauth_authorization_codes');
        $this->addSql('DROP TABLE IF EXISTS oauth_clients');
        $this->addSql('DROP TABLE IF EXISTS oauth_jwt');
        $this->addSql('DROP TABLE IF EXISTS oauth_refresh_tokens');
        $this->addSql('DROP TABLE IF EXISTS oauth_scopes');
        $this->addSql('DROP TABLE IF EXISTS oauth_users');
    }
}
