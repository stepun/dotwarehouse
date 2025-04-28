Примерная структура модуля по-умолчанию на базе которой можно создавать свои модули 

src/Cabinet/src/
├── Collection/
│   └── WarehouseCollection.php
├── Entity/
│   └── Warehouse.php
├── Handler/
│   └── WarehouseHandler.php
├── InputFilter/
│   ├── Input/
│   ├── ├── WarehouseCollectionHandler
│   │   └── NameInput.php
│   └── WarehouseInputFilter.php
├── Repository/
│   └── WarehouseRepository.php
├── Service/
│   ├── WarehouseService.php
│   └── WarehouseServiceInterface.php
├── ConfigProvider.php
└── RoutesDelegator.php

src/Cabinet/src/Collection/WarehouseCollection.php - a collection refers to a container for a group of related objects, typically used to manage sets of related entities fetched from a database
src/Cabinet/src/Entity/Warehouse.php - an entity refers to a PHP class that represents a persistent object or data structure
src/Cabinet/src/Handler/WarehouseHandler.php - handlers are middleware that can handle requests based on an action
src/Cabinet/src/Repository/WarehouseRepository.php - a repository is a class responsible for querying and retrieving entities from the database
src/Cabinet/src/Service/WarehouseService.php - is a class or component responsible for performing a specific task or providing functionality to other parts of the application
src/Cabinet/src/ConfigProvider.php - is a class that provides configuration for various aspects of the framework or application
src/Cabinet/src/RoutesDelegator.php - a routes delegator is a delegator factory responsible for configuring routing middleware based on routing configuration provided by the application
src/Cabinet/src/InputFilter/WarehouseInputFilter.php - input filters and validators
src/Cabinet/src/InputFilter/Input/* - input filters and validator configurations
