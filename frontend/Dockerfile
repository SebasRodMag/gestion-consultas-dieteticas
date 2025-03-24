FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

FROM httpd:2.4-alpine

COPY --from=builder /app/dist/ /usr/local/apache2/htdocs/

EXPOSE 80

# Apache se inicia por defecto en esta imagen base