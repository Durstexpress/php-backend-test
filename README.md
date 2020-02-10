# Durstexpress PHP test

### Tour task: 
0. Setup environment as described in next section ( see [setup](#setup))

1. Create basic CRUD operations for Drinks management (name, type, contains alcohol, price, bottle deposit price, package) 

2. Add validation to your form 

3. (Optional, good to have) Expose also API endpoints for each operation 

_No requirement to finish test completely. You should not spend more than 3-4 hours, just push your solution._ 

As result we are expecting to receive pull request with name in format <TEST-YOUR_NAME>.  


### Setup

##### 1. Clone project
```bash
git clone git@github.com:Durstexpress/durstexpress-ecommerce-configapi.git
```
##### 2. Copy  `docker-compose.yml.dist` to `docker-compose.yml` and update http port if needed
```bash
cp docker-compose.yml.dist docker-compose.yml
```

```yaml
version: '3.1'

services:
  app:
    build:
      context: ./
      dockerfile: docker/Dockerfile
    ports:
      - '8000:80/tcp' # <--- change to any free port on yours machine
    volumes:
      - ./:/var/www/html
    environment:
      - 'APP_ENV=dev'
      - 'APP_SECRET=14523d2734f4c2a13137acc93ae9774a'
```

##### 3. Build your image
```bash
docker-compose build
```

##### 4. Start your container
```yaml
docker-compose up -d
```

##### 5. (Only first time) Install dependencies inside container
Explanation: Composer dependencies are installed during the image build, so they are already inside of container and for production this step not needed. 
But locally once you mount volume with docker-compose (or without it), vendor(basically whole `/var/www/html`) folder is overwritten by yours local one, that is basically doesn't exist right after clone.
When this step will be executed you will have `vendor` folder locally same as in container and when next time you will start container it will be copied inside.
```yaml
docker-compose exec -u 1000 app bash # connected to container as regular user 
composer install
```

##### 6. You are done. Now you can test service by url `http://localhost:8000` or `localhost:<port_that_you_put_in_compose_file>`

 


