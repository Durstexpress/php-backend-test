# Durstexpress PHP test

### Requirement
* Docker Latest
* Docker Composer >=3.5

### Setup

##### 1. Build
```bash
docker-compose build app
```

##### 2. Start your container
```yaml
docker-compose up -d --remove-orphans app
```

### Setup with make

##### 1. Build
```bash
make install
```

##### 2. Start your container
```bash
make start
```

I Added more convenience `make command` for stopping, cleaning and viewing application logs 

##### Stopping your container
```bash
make stop
```

##### Cleaning your container
```bash
make clean
```

##### Viewing application logs
```bash
make watch-logs
```

### Viewing Application

Application can be viewed in brower by visiting [http://localhost:11091/](http://localhost:11091/)
 


