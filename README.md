# robocoin
Test application

## 1. Config
### .env
This file for docker compose. Example in example.env
### app/config.neon
This file for Nette Framework. Example in app/example.neon
## 2. Run in docker
```
docker-compose up
```
## 3. Apply migrations
run in docker container:
```
app/migrations php run structures basic
```