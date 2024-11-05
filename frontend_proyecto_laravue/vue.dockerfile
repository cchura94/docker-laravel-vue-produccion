FROM node:20 as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY ./ .
RUN npm run build

FROM nginx as production-stage
EXPOSE 3000
COPY nginx.conf /etc/nginx/nginx.d/default.conf
COPY --from=build-stage /app/dist/ /usr/share/nginx/html