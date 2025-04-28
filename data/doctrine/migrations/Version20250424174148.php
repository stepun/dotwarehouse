<?php

declare(strict_types=1);

namespace Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424174148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement DROP FOREIGN KEY FK_movement_stock
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement DROP FOREIGN KEY FK_movement_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement DROP FOREIGN KEY FK_movement_operation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE price_list DROP FOREIGN KEY FK_price_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE price_list DROP FOREIGN KEY FK_price_nomenclature
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cabinet DROP FOREIGN KEY FK_cabinet_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature DROP FOREIGN KEY FK_nomenclature_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse_operation DROP FOREIGN KEY FK_operation_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cabinet_employee DROP FOREIGN KEY FK_cabinet_employee
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock DROP FOREIGN KEY FK_stock_warehouse
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock DROP FOREIGN KEY FK_stock_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock DROP FOREIGN KEY FK_stock_nomenclature
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE price_list
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cabinet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nomenclature
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE warehouse_operation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cabinet_employee
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse DROP FOREIGN KEY FK_warehouse_cabinet
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_warehouse_cabinet ON warehouse
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL, DROP cabinet_uuid, DROP type, DROP identifier, DROP created_at, DROP updated_at, CHANGE uuid uuid BINARY(16) NOT NULL, CHANGE name name VARCHAR(100) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор движения', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', stock_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор остатка', operation_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор операции', document_number VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Номер документа', document_date DATETIME NOT NULL COMMENT 'Дата и время документа', price NUMERIC(15, 2) NOT NULL COMMENT 'Цена прихода/расхода', original_price NUMERIC(15, 2) NOT NULL COMMENT 'Оригинальная цена товара', discount NUMERIC(15, 2) DEFAULT '0.00' COMMENT 'Скидка', vat_rate NUMERIC(5, 2) NOT NULL COMMENT 'Ставка НДС', vat_amount NUMERIC(15, 2) NOT NULL COMMENT 'Сумма НДС', quantity NUMERIC(15, 3) NOT NULL COMMENT 'Количество', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_movement_operation (operation_uuid), INDEX IDX_movement_cabinet (cabinet_uuid), INDEX IDX_movement_stock (stock_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'История движения товаров' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE price_list (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор цены', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', nomenclature_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор номенклатуры', name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Название прайс-листа', original_price NUMERIC(15, 2) NOT NULL COMMENT 'Оригинальная цена продажи', discount NUMERIC(15, 2) DEFAULT '0.00' COMMENT 'Скидка на товар', price_with_discount NUMERIC(15, 2) NOT NULL COMMENT 'Цена с учетом скидки', vat_rate NUMERIC(5, 2) NOT NULL COMMENT 'Ставка НДС', vat_amount NUMERIC(15, 2) NOT NULL COMMENT 'Сумма НДС', valid_from DATETIME NOT NULL COMMENT 'Дата начала действия цены', valid_to DATETIME DEFAULT NULL COMMENT 'Дата окончания действия цены', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_price_cabinet (cabinet_uuid), INDEX IDX_price_nomenclature (nomenclature_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Прайс-листы' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cabinet (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор кабинета', name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Название кабинета', status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Статус кабинета (активный, заблокированный и т.д.)', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', user_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор владельца кабинета', INDEX IDX_cabinet_user (user_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Кабинеты складского учета' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE nomenclature (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор номенклатуры', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Название товара', type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Тип товара', unit VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Единица измерения', article VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Артикул товара', manufacturer VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Производитель', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_nomenclature_cabinet (cabinet_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Справочник номенклатуры' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE warehouse_operation (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор операции', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Название операции (приход, расход, перемещение и т.д.)', type TINYINT(1) NOT NULL COMMENT '1 - приход, 2 - расход', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_operation_cabinet (cabinet_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Справочник складских операций' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cabinet_employee (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор сотрудника', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', first_name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Имя сотрудника', last_name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Фамилия сотрудника', position VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Должность сотрудника', status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT 'Статус сотрудника (активный, уволен и т.д.)', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_cabinet_employee (cabinet_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Сотрудники кабинета' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock (uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор остатка', cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', nomenclature_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор номенклатуры', warehouse_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор склада первичного прихода', purchase_price NUMERIC(15, 2) NOT NULL COMMENT 'Цена прихода на склад', quantity NUMERIC(15, 3) NOT NULL COMMENT 'Количество остатка', created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', INDEX IDX_stock_cabinet (cabinet_uuid), INDEX IDX_stock_nomenclature (nomenclature_uuid), INDEX IDX_stock_warehouse (warehouse_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = 'Остатки товаров' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement ADD CONSTRAINT FK_movement_stock FOREIGN KEY (stock_uuid) REFERENCES stock (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement ADD CONSTRAINT FK_movement_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement ADD CONSTRAINT FK_movement_operation FOREIGN KEY (operation_uuid) REFERENCES warehouse_operation (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE price_list ADD CONSTRAINT FK_price_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE price_list ADD CONSTRAINT FK_price_nomenclature FOREIGN KEY (nomenclature_uuid) REFERENCES nomenclature (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cabinet ADD CONSTRAINT FK_cabinet_user FOREIGN KEY (user_uuid) REFERENCES user (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nomenclature ADD CONSTRAINT FK_nomenclature_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse_operation ADD CONSTRAINT FK_operation_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cabinet_employee ADD CONSTRAINT FK_cabinet_employee FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock ADD CONSTRAINT FK_stock_warehouse FOREIGN KEY (warehouse_uuid) REFERENCES warehouse (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock ADD CONSTRAINT FK_stock_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock ADD CONSTRAINT FK_stock_nomenclature FOREIGN KEY (nomenclature_uuid) REFERENCES nomenclature (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse ADD cabinet_uuid BINARY(16) NOT NULL COMMENT 'Идентификатор кабинета', ADD type VARCHAR(50) NOT NULL COMMENT 'Тип склада', ADD identifier VARCHAR(100) NOT NULL COMMENT 'Внутренний идентификатор склада', ADD created_at DATETIME NOT NULL COMMENT 'Дата и время создания записи', ADD updated_at DATETIME DEFAULT NULL COMMENT 'Дата и время последнего обновления записи', DROP created, DROP updated, CHANGE uuid uuid BINARY(16) NOT NULL COMMENT 'Уникальный идентификатор склада', CHANGE name name VARCHAR(191) NOT NULL COMMENT 'Название склада'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE warehouse ADD CONSTRAINT FK_warehouse_cabinet FOREIGN KEY (cabinet_uuid) REFERENCES cabinet (uuid)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_warehouse_cabinet ON warehouse (cabinet_uuid)
        SQL);
    }
}
