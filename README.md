# Durstexpress PHP Backend Test

### Installation

##### 1. Clone project
```bash
git clone git@github.com:Durstexpress/php-backend-test.git
```

##### 2. Copy  `docker-compose.yml.dist` to `docker-compose.yml` and update HTTP port if needed
```bash
cp docker-compose.yml.dist docker-compose.yml
```

```yaml
services:
  app:
    ...
    ...
    ports:
      - '80:80' # <--- change to any free port on yours machine
    ...
    ...    
```

##### 3. Build and start all containers
```bash
docker-compose up -d --build
```
       
##### 4. (Only first time) Install project dependencies, run migrations and seeder
```bash
docker-compose exec -u 1000 app bash # connect to our app container

composer install
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```

##### 5. Build frontend assets:
```bash
docker-compose run --rm encore yarn build
```
