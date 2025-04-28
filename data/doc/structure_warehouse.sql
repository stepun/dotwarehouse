-- Таблица кабинетов складского учета
CREATE TABLE `cabinet` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор кабинета',
`name` varchar(191) NOT NULL COMMENT 'Название кабинета',
`status` varchar(20) NOT NULL COMMENT 'Статус кабинета (активный, заблокированный и т.д.)',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
`user_uuid` binary(16) NOT NULL COMMENT 'Идентификатор владельца кабинета',
PRIMARY KEY (`uuid`),
KEY `IDX_cabinet_user` (`user_uuid`),
CONSTRAINT `FK_cabinet_user` FOREIGN KEY (`user_uuid`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Кабинеты складского учета';

-- Таблица сотрудников кабинета
CREATE TABLE `cabinet_employee` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор сотрудника',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`first_name` varchar(191) NOT NULL COMMENT 'Имя сотрудника',
`last_name` varchar(191) NOT NULL COMMENT 'Фамилия сотрудника',
`position` varchar(191) DEFAULT NULL COMMENT 'Должность сотрудника',
`status` varchar(20) NOT NULL COMMENT 'Статус сотрудника (активный, уволен и т.д.)',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_cabinet_employee` (`cabinet_uuid`),
CONSTRAINT `FK_cabinet_employee` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Сотрудники кабинета';

-- Таблица номенклатуры
CREATE TABLE `nomenclature` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор номенклатуры',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`name` varchar(191) NOT NULL COMMENT 'Название товара',
`type` varchar(50) NOT NULL COMMENT 'Тип товара',
`unit` varchar(50) NOT NULL COMMENT 'Единица измерения',
`article` varchar(100) NOT NULL COMMENT 'Артикул товара',
`manufacturer` varchar(191) NOT NULL COMMENT 'Производитель',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_nomenclature_cabinet` (`cabinet_uuid`),
CONSTRAINT `FK_nomenclature_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Справочник номенклатуры';

-- Таблица складов
CREATE TABLE `warehouse` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор склада',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`name` varchar(191) NOT NULL COMMENT 'Название склада',
`type` varchar(50) NOT NULL COMMENT 'Тип склада',
`identifier` varchar(100) NOT NULL COMMENT 'Внутренний идентификатор склада',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_warehouse_cabinet` (`cabinet_uuid`),
CONSTRAINT `FK_warehouse_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Склады';

-- Таблица складских операций
CREATE TABLE `warehouse_operation` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор операции',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`name` varchar(191) NOT NULL COMMENT 'Название операции (приход, расход, перемещение и т.д.)',
`type` tinyint(1) NOT NULL COMMENT '1 - приход, 2 - расход',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_operation_cabinet` (`cabinet_uuid`),
CONSTRAINT `FK_operation_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Справочник складских операций';

-- Таблица остатков
CREATE TABLE `stock` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор остатка',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`nomenclature_uuid` binary(16) NOT NULL COMMENT 'Идентификатор номенклатуры',
`warehouse_uuid` binary(16) NOT NULL COMMENT 'Идентификатор склада первичного прихода',
`purchase_price` decimal(15,2) NOT NULL COMMENT 'Цена прихода на склад',
`quantity` decimal(15,3) NOT NULL COMMENT 'Количество остатка',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_stock_cabinet` (`cabinet_uuid`),
KEY `IDX_stock_nomenclature` (`nomenclature_uuid`),
KEY `IDX_stock_warehouse` (`warehouse_uuid`),
CONSTRAINT `FK_stock_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`),
CONSTRAINT `FK_stock_nomenclature` FOREIGN KEY (`nomenclature_uuid`) REFERENCES `nomenclature` (`uuid`),
CONSTRAINT `FK_stock_warehouse` FOREIGN KEY (`warehouse_uuid`) REFERENCES `warehouse` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Остатки товаров';

-- Таблица движения остатков
CREATE TABLE `stock_movement` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор движения',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`stock_uuid` binary(16) NOT NULL COMMENT 'Идентификатор остатка',
`operation_uuid` binary(16) NOT NULL COMMENT 'Идентификатор операции',
`document_number` varchar(100) NOT NULL COMMENT 'Номер документа',
`document_date` datetime NOT NULL COMMENT 'Дата и время документа',
`price` decimal(15,2) NOT NULL COMMENT 'Цена прихода/расхода',
`original_price` decimal(15,2) NOT NULL COMMENT 'Оригинальная цена товара',
`discount` decimal(15,2) DEFAULT 0.00 COMMENT 'Скидка',
`vat_rate` decimal(5,2) NOT NULL COMMENT 'Ставка НДС',
`vat_amount` decimal(15,2) NOT NULL COMMENT 'Сумма НДС',
`quantity` decimal(15,3) NOT NULL COMMENT 'Количество',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_movement_cabinet` (`cabinet_uuid`),
KEY `IDX_movement_stock` (`stock_uuid`),
KEY `IDX_movement_operation` (`operation_uuid`),
CONSTRAINT `FK_movement_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`),
CONSTRAINT `FK_movement_stock` FOREIGN KEY (`stock_uuid`) REFERENCES `stock` (`uuid`),
CONSTRAINT `FK_movement_operation` FOREIGN KEY (`operation_uuid`) REFERENCES `warehouse_operation` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='История движения товаров';

-- Таблица цен продажи
CREATE TABLE `price_list` (
`uuid` binary(16) NOT NULL COMMENT 'Уникальный идентификатор цены',
`cabinet_uuid` binary(16) NOT NULL COMMENT 'Идентификатор кабинета',
`nomenclature_uuid` binary(16) NOT NULL COMMENT 'Идентификатор номенклатуры',
`name` varchar(191) NOT NULL COMMENT 'Название прайс-листа',
`original_price` decimal(15,2) NOT NULL COMMENT 'Оригинальная цена продажи',
`discount` decimal(15,2) DEFAULT 0.00 COMMENT 'Скидка на товар',
`price_with_discount` decimal(15,2) NOT NULL COMMENT 'Цена с учетом скидки',
`vat_rate` decimal(5,2) NOT NULL COMMENT 'Ставка НДС',
`vat_amount` decimal(15,2) NOT NULL COMMENT 'Сумма НДС',
`valid_from` datetime NOT NULL COMMENT 'Дата начала действия цены',
`valid_to` datetime DEFAULT NULL COMMENT 'Дата окончания действия цены',
`created_at` datetime NOT NULL COMMENT 'Дата и время создания записи',
`updated_at` datetime DEFAULT NULL COMMENT 'Дата и время последнего обновления записи',
PRIMARY KEY (`uuid`),
KEY `IDX_price_cabinet` (`cabinet_uuid`),
KEY `IDX_price_nomenclature` (`nomenclature_uuid`),
CONSTRAINT `FK_price_cabinet` FOREIGN KEY (`cabinet_uuid`) REFERENCES `cabinet` (`uuid`),
CONSTRAINT `FK_price_nomenclature` FOREIGN KEY (`nomenclature_uuid`) REFERENCES `nomenclature` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Прайс-листы';

