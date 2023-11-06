# DataForge

### A service for getting metrics data from different services

**Stack of technologies:**
* Backend: PHP;
* Web-server: Nginx;
* Database: Mysql
* Frontend: Html, Css;
* Virtualization: Docker/Docker-compose
* Patterns: SOLID, DRY

### Installation

1. Download and install docker/docker-compose

2. Clone repository
```
git clone https://github.com/vladanokhin/data-forge
```

### Configure project and docker

1. Copy laravel `.env.example` file to `.env` and change it's variables
```
cp ~/DataForge/.env.example ~/DataForge/.env
```

2. Copy docker `docker/.env.example` to `docker/.env` and change it's variables
```
cp ~/DataForge/docker/.env.example ~/DataForge/docker/.env
```

3. Start docker containers
```
cd ~/DataForge/docker
docker-compose up -d
```

### Init project

1. Enter workspace container
```
cd ~/DataForge/docker/ 
docker-compose exec workspace bash
```

3. Install composer
```
composer install
```

4. Create database from dump
```
data/init.sql
```
