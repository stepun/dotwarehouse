#!/bin/bash

# Цвета для вывода
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# URL API
API_URL="https://dockernel-api.dvl.to/api/v1/client/register"

# Заголовки для запросов
HEADERS=(
  "Content-Type: application/json"
  "Accept: application/json"
  "X-API-Key: test-api-key"  # Добавляем тестовый API ключ
)

echo -e "${YELLOW}Тестирование API регистрации клиента${NC}"
echo "----------------------------------------"

# Тест 1: Успешная регистрация
echo -e "${YELLOW}Тест 1: Успешная регистрация${NC}"
echo "Отправка запроса на $API_URL"
echo "Данные: {\"identity\": \"testclient\", \"password\": \"TestPassword123\", \"cabinetName\": \"Тестовый кабинет\"}"

# Формируем строку заголовков для curl
HEADERS_STR=""
for header in "${HEADERS[@]}"; do
  HEADERS_STR="$HEADERS_STR -H '$header'"
done

RESPONSE=$(curl -s -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "testclient",
    "password": "TestPassword123",
    "cabinetName": "Тестовый кабинет"
  }')

STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "testclient",
    "password": "TestPassword123",
    "cabinetName": "Тестовый кабинет"
  }')

if [ "$STATUS_CODE" -eq 201 ]; then
  echo -e "${GREEN}Успешно! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
else
  echo -e "${RED}Ошибка! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
fi

echo "----------------------------------------"

# Тест 2: Ошибка валидации
echo -e "${YELLOW}Тест 2: Ошибка валидации${NC}"
echo "Отправка запроса с некорректными данными"

RESPONSE=$(curl -s -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "te",
    "password": "123",
    "cabinetName": "Те"
  }')

STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "te",
    "password": "123",
    "cabinetName": "Те"
  }')

if [ "$STATUS_CODE" -eq 400 ]; then
  echo -e "${GREEN}Успешно! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
else
  echo -e "${RED}Ошибка! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
fi

echo "----------------------------------------"

# Тест 3: Отсутствие обязательных полей
echo -e "${YELLOW}Тест 3: Отсутствие обязательных полей${NC}"
echo "Отправка запроса с отсутствующими полями"

RESPONSE=$(curl -s -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "testclient"
  }')

STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
  $API_URL \
  $HEADERS_STR \
  -d '{
    "identity": "testclient"
  }')

if [ "$STATUS_CODE" -eq 400 ]; then
  echo -e "${GREEN}Успешно! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
else
  echo -e "${RED}Ошибка! Код ответа: $STATUS_CODE${NC}"
  echo "Ответ:"
  echo $RESPONSE
fi

echo "----------------------------------------"
echo -e "${YELLOW}Тестирование завершено${NC}" 