# Пример регистрации клиента

## Описание

API для регистрации нового клиента, создания кабинета и склада по умолчанию.

## Endpoint

```
POST /api/v1/client/register
```

## Заголовки запроса

```
Content-Type: application/json
```

## Тело запроса

```json
{
  "identity": "testclient",
  "password": "TestPassword123",
  "cabinetName": "Тестовый кабинет"
}
```

## Пример запроса с использованием curl

```bash
curl -X POST \
  hhttps://dockernel-api.dvl.to/api/v1/client/register \
  -H 'Content-Type: application/json' \
  -d '{
    "identity": "testclient",
    "password": "TestPassword123",
    "cabinetName": "Тестовый кабинет"
  }'
```

## Успешный ответ (код 201)

```json
{
  "status": "success",
  "data": {
    "user": {
      "uuid": "550e8400-e29b-41d4-a716-446655440000",
      "identity": "testclient",
      "status": "active"
    },
    "cabinet": {
      "uuid": "550e8400-e29b-41d4-a716-446655440001",
      "name": "Тестовый кабинет",
      "status": "active"
    },
    "warehouse": {
      "uuid": "550e8400-e29b-41d4-a716-446655440002",
      "name": "Основной склад",
      "type": "main",
      "identifier": "MAIN-550e8400-e29b-41d4-a716-446655440001"
    }
  }
}
```

## Ошибка валидации (код 400)

```json
{
  "status": "error",
  "messages": {
    "identity": {
      "stringLengthTooShort": "Введите не менее 3 символов"
    },
    "password": {
      "stringLengthTooShort": "Введите не менее 8 символов"
    },
    "cabinetName": {
      "stringLengthTooShort": "Введите не менее 3 символов"
    }
  }
}
```

## Ошибка сервера (код 500)

```json
{
  "status": "error",
  "message": "Ошибка при регистрации клиента: [текст ошибки]"
}
```

## Требования к данным

- **identity**: строка, 3-100 символов, только буквы, цифры и символ подчеркивания
- **password**: строка, минимум 8 символов
- **cabinetName**: строка, 3-191 символа 