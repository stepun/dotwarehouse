CREATE TABLE `admin` (
                         `uuid` binary(16) NOT NULL,
                         `identity` varchar(100) NOT NULL,
                         `firstName` varchar(191) NOT NULL,
                         `lastName` varchar(191) NOT NULL,
                         `password` varchar(100) NOT NULL,
                         `status` varchar(20) NOT NULL,
                         `created` datetime NOT NULL,
                         `updated` datetime DEFAULT NULL,
                         PRIMARY KEY (`uuid`),
                         UNIQUE KEY `UNIQ_880E0D766A95E9C4` (`identity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `admin_role` (
                              `uuid` binary(16) NOT NULL,
                              `name` varchar(30) NOT NULL,
                              `created` datetime NOT NULL,
                              `updated` datetime DEFAULT NULL,
                              PRIMARY KEY (`uuid`),
                              UNIQUE KEY `UNIQ_7770088A5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `admin_roles` (
                               `userUuid` binary(16) NOT NULL,
                               `roleUuid` binary(16) NOT NULL,
                               PRIMARY KEY (`userUuid`,`roleUuid`),
                               KEY `IDX_1614D53DD73087E9` (`userUuid`),
                               KEY `IDX_1614D53D88446210` (`roleUuid`),
                               CONSTRAINT `FK_1614D53D88446210` FOREIGN KEY (`roleUuid`) REFERENCES `admin_role` (`uuid`),
                               CONSTRAINT `FK_1614D53DD73087E9` FOREIGN KEY (`userUuid`) REFERENCES `admin` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `doctrine_migration_versions` (
                                               `version` varchar(191) NOT NULL,
                                               `executed_at` datetime DEFAULT NULL,
                                               `execution_time` int(11) DEFAULT NULL,
                                               PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_access_token_scopes` (
                                             `access_token_id` int(10) unsigned NOT NULL,
                                             `scope_id` int(10) unsigned NOT NULL,
                                             PRIMARY KEY (`access_token_id`,`scope_id`),
                                             KEY `IDX_9FDF62E92CCB2688` (`access_token_id`),
                                             KEY `IDX_9FDF62E9682B5931` (`scope_id`),
                                             CONSTRAINT `FK_9FDF62E92CCB2688` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`),
                                             CONSTRAINT `FK_9FDF62E9682B5931` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_access_tokens` (
                                       `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                       `user_id` varchar(25) DEFAULT NULL,
                                       `token` varchar(100) NOT NULL,
                                       `revoked` tinyint(1) NOT NULL DEFAULT 0,
                                       `expires_at` datetime NOT NULL,
                                       `client_id` int(10) unsigned DEFAULT NULL,
                                       PRIMARY KEY (`id`),
                                       KEY `IDX_CA42527C19EB6921` (`client_id`),
                                       CONSTRAINT `FK_CA42527C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_auth_code_scopes` (
                                          `auth_code_id` int(10) unsigned NOT NULL,
                                          `scope_id` int(10) unsigned NOT NULL,
                                          PRIMARY KEY (`auth_code_id`,`scope_id`),
                                          KEY `IDX_988BFFBF69FEDEE4` (`auth_code_id`),
                                          KEY `IDX_988BFFBF682B5931` (`scope_id`),
                                          CONSTRAINT `FK_988BFFBF682B5931` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`),
                                          CONSTRAINT `FK_988BFFBF69FEDEE4` FOREIGN KEY (`auth_code_id`) REFERENCES `oauth_auth_codes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_auth_codes` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `revoked` tinyint(1) NOT NULL DEFAULT 0,
                                    `expiresDatetime` datetime DEFAULT NULL,
                                    `client_id` int(10) unsigned DEFAULT NULL,
                                    PRIMARY KEY (`id`),
                                    KEY `IDX_BB493F8319EB6921` (`client_id`),
                                    CONSTRAINT `FK_BB493F8319EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_clients` (
                                 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `name` varchar(40) NOT NULL,
                                 `secret` varchar(100) DEFAULT NULL,
                                 `redirect` varchar(191) NOT NULL,
                                 `revoked` tinyint(1) NOT NULL DEFAULT 0,
                                 `isConfidential` tinyint(1) NOT NULL DEFAULT 0,
                                 `user_id` binary(16) DEFAULT NULL,
                                 PRIMARY KEY (`id`),
                                 KEY `IDX_13CE8101A76ED395` (`user_id`),
                                 CONSTRAINT `FK_13CE8101A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_refresh_tokens` (
                                        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                        `revoked` tinyint(1) NOT NULL DEFAULT 0,
                                        `expires_at` datetime NOT NULL,
                                        `access_token_id` int(10) unsigned DEFAULT NULL,
                                        PRIMARY KEY (`id`),
                                        KEY `IDX_5AB6872CCB2688` (`access_token_id`),
                                        CONSTRAINT `FK_5AB6872CCB2688` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `oauth_scopes` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `scope` varchar(191) NOT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `user` (
                        `uuid` binary(16) NOT NULL,
                        `identity` varchar(191) NOT NULL,
                        `password` varchar(191) NOT NULL,
                        `status` varchar(20) NOT NULL,
                        `isDeleted` tinyint(1) NOT NULL,
                        `hash` varchar(64) NOT NULL,
                        `created` datetime NOT NULL,
                        `updated` datetime DEFAULT NULL,
                        PRIMARY KEY (`uuid`),
                        UNIQUE KEY `UNIQ_8D93D6496A95E9C4` (`identity`),
                        UNIQUE KEY `UNIQ_8D93D649D1B862B8` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `user_avatar` (
                               `uuid` binary(16) NOT NULL,
                               `name` varchar(191) NOT NULL,
                               `created` datetime NOT NULL,
                               `updated` datetime DEFAULT NULL,
                               `userUuid` binary(16) DEFAULT NULL,
                               PRIMARY KEY (`uuid`),
                               UNIQUE KEY `UNIQ_73256912D73087E9` (`userUuid`),
                               CONSTRAINT `FK_73256912D73087E9` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
CREATE TABLE `user_detail` (
                               `uuid` binary(16) NOT NULL,
                               `firstName` varchar(191) DEFAULT NULL,
                               `lastName` varchar(191) DEFAULT NULL,
                               `email` varchar(191) NOT NULL,
                               `created` datetime NOT NULL,
                               `updated` datetime DEFAULT NULL,
                               `userUuid` binary(16) DEFAULT NULL,
                               PRIMARY KEY (`uuid`),
                               UNIQUE KEY `UNIQ_4B5464AED73087E9` (`userUuid`),
                               CONSTRAINT `FK_4B5464AED73087E9` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `user_reset_password` (
                                       `uuid` binary(16) NOT NULL,
                                       `expires` datetime NOT NULL,
                                       `hash` varchar(64) NOT NULL,
                                       `status` varchar(20) NOT NULL,
                                       `created` datetime NOT NULL,
                                       `updated` datetime DEFAULT NULL,
                                       `userUuid` binary(16) DEFAULT NULL,
                                       PRIMARY KEY (`uuid`),
                                       UNIQUE KEY `UNIQ_D21DE3BCD1B862B8` (`hash`),
                                       KEY `IDX_D21DE3BCD73087E9` (`userUuid`),
                                       CONSTRAINT `FK_D21DE3BCD73087E9` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `user_role` (
                             `uuid` binary(16) NOT NULL,
                             `name` varchar(20) NOT NULL,
                             `created` datetime NOT NULL,
                             `updated` datetime DEFAULT NULL,
                             PRIMARY KEY (`uuid`),
                             UNIQUE KEY `UNIQ_2DE8C6A35E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `user_roles` (
                              `userUuid` binary(16) NOT NULL,
                              `roleUuid` binary(16) NOT NULL,
                              PRIMARY KEY (`userUuid`,`roleUuid`),
                              KEY `IDX_54FCD59FD73087E9` (`userUuid`),
                              KEY `IDX_54FCD59F88446210` (`roleUuid`),
                              CONSTRAINT `FK_54FCD59F88446210` FOREIGN KEY (`roleUuid`) REFERENCES `user_role` (`uuid`),
                              CONSTRAINT `FK_54FCD59FD73087E9` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
