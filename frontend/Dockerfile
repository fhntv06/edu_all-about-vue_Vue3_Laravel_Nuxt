# Базовый этап с Node.js
FROM node:20-alpine AS base

WORKDIR /app

# Копирование файлов зависимостей
COPY package*.json ./

# Этап установки зависимостей (кэшируется отдельно)
FROM base AS deps
RUN npm ci

# Этап разработки
FROM base AS development
COPY --from=deps /app/node_modules /app/node_modules
COPY . .

# Права на node_modules
RUN chown -R node:node /app/node_modules

USER node

EXPOSE 5173 8888

CMD ["npm", "run", "dev"]

# Этап сборки
FROM deps AS build
COPY . .
RUN npm run build

# Production этап
FROM nginx:alpine AS production
COPY --from=build /app/dist /usr/share/nginx/html
COPY ./docker/nginx-frontend.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]