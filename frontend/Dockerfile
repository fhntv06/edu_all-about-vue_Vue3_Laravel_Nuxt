# Единый базовый образ
FROM node:20-alpine AS base

WORKDIR /var/www/html/frontend

# Копирование файлов зависимостей
COPY package*.json ./

# Этап установки зависимостей
FROM base AS deps
RUN npm ci

# Этап сборки
FROM base AS production

# Копирование node_modules из этапа deps
COPY --from=deps /var/www/html/frontend/node_modules ./node_modules

# Копирование исходного кода
COPY . .

# Сборка проекта
RUN npm run build