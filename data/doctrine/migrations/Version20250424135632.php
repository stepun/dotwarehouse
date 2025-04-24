<?php

declare(strict_types=1);

namespace Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424135632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE admin (uuid BINARY(16) NOT NULL, identity VARCHAR(100) NOT NULL, firstName VARCHAR(191) NOT NULL, lastName VARCHAR(191) NOT NULL, password VARCHAR(100) NOT NULL, status VARCHAR(20) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D766A95E9C4 (identity), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE admin_roles (userUuid BINARY(16) NOT NULL, roleUuid BINARY(16) NOT NULL, INDEX IDX_1614D53DD73087E9 (userUuid), INDEX IDX_1614D53D88446210 (roleUuid), PRIMARY KEY(userUuid, roleUuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE admin_role (uuid BINARY(16) NOT NULL, name VARCHAR(30) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7770088A5E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_access_token_scopes (access_token_id INT UNSIGNED NOT NULL, scope_id INT UNSIGNED NOT NULL, INDEX IDX_9FDF62E92CCB2688 (access_token_id), INDEX IDX_9FDF62E9682B5931 (scope_id), PRIMARY KEY(access_token_id, scope_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_auth_codes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, revoked TINYINT(1) DEFAULT 0 NOT NULL, expiresDatetime DATETIME DEFAULT NULL, client_id INT UNSIGNED DEFAULT NULL, INDEX IDX_BB493F8319EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_auth_code_scopes (auth_code_id INT UNSIGNED NOT NULL, scope_id INT UNSIGNED NOT NULL, INDEX IDX_988BFFBF69FEDEE4 (auth_code_id), INDEX IDX_988BFFBF682B5931 (scope_id), PRIMARY KEY(auth_code_id, scope_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (uuid BINARY(16) NOT NULL, identity VARCHAR(191) NOT NULL, password VARCHAR(191) NOT NULL, status VARCHAR(20) NOT NULL, isDeleted TINYINT(1) NOT NULL, hash VARCHAR(64) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6496A95E9C4 (identity), UNIQUE INDEX UNIQ_8D93D649D1B862B8 (hash), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_roles (userUuid BINARY(16) NOT NULL, roleUuid BINARY(16) NOT NULL, INDEX IDX_54FCD59FD73087E9 (userUuid), INDEX IDX_54FCD59F88446210 (roleUuid), PRIMARY KEY(userUuid, roleUuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_avatar (uuid BINARY(16) NOT NULL, name VARCHAR(191) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_73256912D73087E9 (userUuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_detail (uuid BINARY(16) NOT NULL, firstName VARCHAR(191) DEFAULT NULL, lastName VARCHAR(191) DEFAULT NULL, email VARCHAR(191) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_4B5464AED73087E9 (userUuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_reset_password (uuid BINARY(16) NOT NULL, expires DATETIME NOT NULL, hash VARCHAR(64) NOT NULL, status VARCHAR(20) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_D21DE3BCD1B862B8 (hash), INDEX IDX_D21DE3BCD73087E9 (userUuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_role (uuid BINARY(16) NOT NULL, name VARCHAR(20) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_2DE8C6A35E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_roles ADD CONSTRAINT FK_1614D53DD73087E9 FOREIGN KEY (userUuid) REFERENCES admin (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_roles ADD CONSTRAINT FK_1614D53D88446210 FOREIGN KEY (roleUuid) REFERENCES admin_role (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_token_scopes ADD CONSTRAINT FK_9FDF62E92CCB2688 FOREIGN KEY (access_token_id) REFERENCES oauth_access_tokens (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_token_scopes ADD CONSTRAINT FK_9FDF62E9682B5931 FOREIGN KEY (scope_id) REFERENCES oauth_scopes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_codes ADD CONSTRAINT FK_BB493F8319EB6921 FOREIGN KEY (client_id) REFERENCES oauth_clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_code_scopes ADD CONSTRAINT FK_988BFFBF69FEDEE4 FOREIGN KEY (auth_code_id) REFERENCES oauth_auth_codes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_code_scopes ADD CONSTRAINT FK_988BFFBF682B5931 FOREIGN KEY (scope_id) REFERENCES oauth_scopes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FD73087E9 FOREIGN KEY (userUuid) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F88446210 FOREIGN KEY (roleUuid) REFERENCES user_role (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_avatar ADD CONSTRAINT FK_73256912D73087E9 FOREIGN KEY (userUuid) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_detail ADD CONSTRAINT FK_4B5464AED73087E9 FOREIGN KEY (userUuid) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_reset_password ADD CONSTRAINT FK_D21DE3BCD73087E9 FOREIGN KEY (userUuid) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices DROP FOREIGN KEY sale_prices_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices DROP FOREIGN KEY sale_prices_ibfk_3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices DROP FOREIGN KEY sale_prices_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP FOREIGN KEY users_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouses DROP FOREIGN KEY warehouses_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouses DROP FOREIGN KEY warehouses_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature DROP FOREIGN KEY nomenclature_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature DROP FOREIGN KEY nomenclature_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements DROP FOREIGN KEY stock_movements_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements DROP FOREIGN KEY stock_movements_ibfk_5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements DROP FOREIGN KEY stock_movements_ibfk_3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements DROP FOREIGN KEY stock_movements_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements DROP FOREIGN KEY stock_movements_ibfk_4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries DROP FOREIGN KEY stock_entries_ibfk_3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries DROP FOREIGN KEY stock_entries_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries DROP FOREIGN KEY stock_entries_ibfk_4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries DROP FOREIGN KEY stock_entries_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_jwt
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sale_prices
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_authorization_codes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE warehouses
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE operation_types
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nomenclature
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE warehouse_account
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movements
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_entries
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL, ADD token VARCHAR(100) NOT NULL, ADD revoked TINYINT(1) DEFAULT 0 NOT NULL, ADD expires_at DATETIME NOT NULL, DROP access_token, DROP expires, DROP scope, CHANGE client_id client_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id VARCHAR(25) DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens ADD CONSTRAINT FK_CA42527C19EB6921 FOREIGN KEY (client_id) REFERENCES oauth_clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CA42527C19EB6921 ON oauth_access_tokens (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL, ADD name VARCHAR(40) NOT NULL, ADD secret VARCHAR(100) DEFAULT NULL, ADD redirect VARCHAR(191) NOT NULL, ADD revoked TINYINT(1) DEFAULT 0 NOT NULL, ADD isConfidential TINYINT(1) DEFAULT 0 NOT NULL, DROP client_id, DROP client_secret, DROP redirect_uri, DROP grant_types, DROP scope, CHANGE user_id user_id BINARY(16) DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients ADD CONSTRAINT FK_13CE8101A76ED395 FOREIGN KEY (user_id) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13CE8101A76ED395 ON oauth_clients (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL, ADD revoked TINYINT(1) DEFAULT 0 NOT NULL, ADD expires_at DATETIME NOT NULL, ADD access_token_id INT UNSIGNED DEFAULT NULL, DROP refresh_token, DROP client_id, DROP user_id, DROP expires, DROP scope, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens ADD CONSTRAINT FK_5AB6872CCB2688 FOREIGN KEY (access_token_id) REFERENCES oauth_access_tokens (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5AB6872CCB2688 ON oauth_refresh_tokens (access_token_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_scopes ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL, DROP type, DROP client_id, DROP is_default, CHANGE scope scope VARCHAR(191) NOT NULL, ADD PRIMARY KEY (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_jwt (client_id VARCHAR(80) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, subject VARCHAR(80) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, public_key VARCHAR(2000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY(client_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sale_prices (id INT AUTO_INCREMENT NOT NULL COMMENT 'Уникальный идентификатор записи', warehouse_account_id INT NOT NULL COMMENT 'Идентификатор кабинета', user_id INT NOT NULL COMMENT 'Идентификатор пользователя, который создал или изменил запись', nomenclature_id INT NOT NULL COMMENT 'Идентификатор номенклатуры', price_list_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Название прайс-листа', original_price NUMERIC(10, 2) NOT NULL COMMENT 'Оригинальная цена продажи', sell_price NUMERIC(10, 2) NOT NULL COMMENT 'цена продажи c учетом всех скидок и НДС', start_date DATETIME NOT NULL COMMENT 'Дата начала действия цены', end_date DATETIME DEFAULT NULL COMMENT 'Дата окончания действия цены', discount NUMERIC(5, 2) DEFAULT '0.00' COMMENT 'Скидка на товар в процентах', discounted_price NUMERIC(10, 2) DEFAULT NULL COMMENT 'Сумма с учетом скидки на товар', vat_rate NUMERIC(10, 2) NOT NULL COMMENT 'Ставка НДС в процентах', vat_amount NUMERIC(10, 2) DEFAULT NULL COMMENT 'Сумма с учетом НДС', created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время последнего изменения записи', INDEX warehouse_account_id (warehouse_account_id), INDEX user_id (user_id), INDEX nomenclature_id (nomenclature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Таблица цен продажи номенклатурных остатков' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_authorization_codes (authorization_code VARCHAR(40) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, client_id VARCHAR(80) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, redirect_uri VARCHAR(2000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, expires DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, scope VARCHAR(2000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, id_token VARCHAR(2000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY(authorization_code)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, warehouse_account_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX email (email), INDEX warehouse_account_id (warehouse_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE oauth_users (username VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, password VARCHAR(2000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, first_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE warehouses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, identifier VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, warehouse_account_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX warehouse_account_id (warehouse_account_id), INDEX created_by_user_id (user_id), UNIQUE INDEX identifier (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE operation_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, operation_type TINYINT(1) DEFAULT 1 NOT NULL COMMENT '1 - income
            2 - expense', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE nomenclature (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, measure VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, article VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, manufacturer VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, warehouse_account_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX warehouse_account_id (warehouse_account_id), INDEX created_by_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE warehouse_account (id INT AUTO_INCREMENT NOT NULL, account_identifier VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX account_identifier (account_identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movements (id INT AUTO_INCREMENT NOT NULL, document_date DATETIME DEFAULT CURRENT_TIMESTAMP, document_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, price NUMERIC(10, 2) DEFAULT NULL, operation_type_id INT DEFAULT NULL, nomenclature_id INT DEFAULT NULL, warehouse_id INT DEFAULT NULL, quantity INT DEFAULT NULL, warehouse_account_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX created_by_user_id (user_id), INDEX nomenclature_id (nomenclature_id), INDEX warehouse_id (warehouse_id), INDEX warehouse_account_id (warehouse_account_id), INDEX operation_type_id (operation_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_entries (id INT AUTO_INCREMENT NOT NULL, nomenclature_id INT DEFAULT NULL, warehouse_id INT DEFAULT NULL, initial_price NUMERIC(10, 2) DEFAULT NULL, sell_price NUMERIC(10, 2) DEFAULT NULL, warehouse_account_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX warehouse_id (warehouse_id), INDEX warehouse_account_id (warehouse_account_id), INDEX created_by_user_id (user_id), INDEX nomenclature_id (nomenclature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices ADD CONSTRAINT sale_prices_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices ADD CONSTRAINT sale_prices_ibfk_3 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sale_prices ADD CONSTRAINT sale_prices_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD CONSTRAINT users_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouses ADD CONSTRAINT warehouses_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouses ADD CONSTRAINT warehouses_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature ADD CONSTRAINT nomenclature_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature ADD CONSTRAINT nomenclature_ibfk_1 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_ibfk_2 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_ibfk_5 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_ibfk_3 FOREIGN KEY (warehouse_id) REFERENCES warehouses (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_ibfk_1 FOREIGN KEY (operation_type_id) REFERENCES operation_types (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_ibfk_4 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries ADD CONSTRAINT stock_entries_ibfk_3 FOREIGN KEY (warehouse_account_id) REFERENCES warehouse_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries ADD CONSTRAINT stock_entries_ibfk_1 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries ADD CONSTRAINT stock_entries_ibfk_4 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_entries ADD CONSTRAINT stock_entries_ibfk_2 FOREIGN KEY (warehouse_id) REFERENCES warehouses (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_roles DROP FOREIGN KEY FK_1614D53DD73087E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_roles DROP FOREIGN KEY FK_1614D53D88446210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_token_scopes DROP FOREIGN KEY FK_9FDF62E92CCB2688
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_token_scopes DROP FOREIGN KEY FK_9FDF62E9682B5931
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_codes DROP FOREIGN KEY FK_BB493F8319EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_code_scopes DROP FOREIGN KEY FK_988BFFBF69FEDEE4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_auth_code_scopes DROP FOREIGN KEY FK_988BFFBF682B5931
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59FD73087E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F88446210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_avatar DROP FOREIGN KEY FK_73256912D73087E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_detail DROP FOREIGN KEY FK_4B5464AED73087E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_reset_password DROP FOREIGN KEY FK_D21DE3BCD73087E9
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin_roles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin_role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_access_token_scopes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_auth_codes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE oauth_auth_code_scopes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_roles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_avatar
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_detail
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_reset_password
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_role
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_scopes MODIFY id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON oauth_scopes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_scopes ADD type VARCHAR(255) DEFAULT 'supported' NOT NULL, ADD client_id VARCHAR(80) DEFAULT NULL, ADD is_default SMALLINT DEFAULT NULL, DROP id, CHANGE scope scope VARCHAR(2000) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens MODIFY id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens DROP FOREIGN KEY FK_CA42527C19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_CA42527C19EB6921 ON oauth_access_tokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON oauth_access_tokens
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens ADD access_token VARCHAR(40) NOT NULL, ADD expires DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD scope VARCHAR(2000) DEFAULT NULL, DROP id, DROP token, DROP revoked, DROP expires_at, CHANGE user_id user_id VARCHAR(255) DEFAULT NULL, CHANGE client_id client_id VARCHAR(80) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_access_tokens ADD PRIMARY KEY (access_token)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens MODIFY id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens DROP FOREIGN KEY FK_5AB6872CCB2688
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5AB6872CCB2688 ON oauth_refresh_tokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON oauth_refresh_tokens
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens ADD refresh_token VARCHAR(40) NOT NULL, ADD client_id VARCHAR(80) NOT NULL, ADD user_id VARCHAR(255) DEFAULT NULL, ADD expires DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD scope VARCHAR(2000) DEFAULT NULL, DROP id, DROP revoked, DROP expires_at, DROP access_token_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_refresh_tokens ADD PRIMARY KEY (refresh_token)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients MODIFY id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients DROP FOREIGN KEY FK_13CE8101A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_13CE8101A76ED395 ON oauth_clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON oauth_clients
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients ADD client_id VARCHAR(80) NOT NULL, ADD client_secret VARCHAR(80) NOT NULL, ADD redirect_uri VARCHAR(2000) NOT NULL, ADD grant_types VARCHAR(80) DEFAULT NULL, ADD scope VARCHAR(2000) DEFAULT NULL, DROP id, DROP name, DROP secret, DROP redirect, DROP revoked, DROP isConfidential, CHANGE user_id user_id VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE oauth_clients ADD PRIMARY KEY (client_id)
        SQL);
    }
}
