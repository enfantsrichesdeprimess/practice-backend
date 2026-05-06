# Simple Space
Workspace with web-server, php, mariadb, node

## 1. Install project
*Note: for the work, you must have git installed*

Clone the repository

`git clone https://github.com/lifestealer86/apache-php-mysql-node`

## 2. Project settings
*Note: settings are in .env file*

| Argument | Description                                                                                                                  |
| -----|------------------------------------------------------------------------------------------------------------------------------|
| USER_LOGIN | User login. Used to set the owner of the files in the container, access via ssh, as a database access login (default: admin) |
| USER_PASSWORD | User password. Used to access via ssh and db (default: admin)                                                                |
| DB_NAME | Database name for the created user (default: db)                                                                                          |
| USER_DB_PASSWORD | Database administrator password (administrator login - root)                                                                 |
| SSH_PORT | Ssh port (default: 22)                                                                                                       |
| WEB_PORT | Web-server port (default: 8080)                                                                                              |
| SERVER_NAME | Server hostname (default: localhost)                                                                                         |
| LARAVEL | Flag for the need to install the framework (default false)                                                                   |
| YII | Flag for the need to install the framework (default false)                                                                   |
| VUE | Flag for the need to install the framework (default false)                                                                   |
| REACT | Flag for the need to install the framework (default false)                                                                   |
| ANGULAR | Flag for the need to install the framework (default false)                                                                   |

## 2. Run project
*Note: for the project to work, you must have docker and docker-compose installed*
*Note: Run inside the project directory*

`docker-compose up -d`
or
`podman-compose up -d`

## 3. Database

The database is initialized automatically from files in `database/init`.

MariaDB data is stored in the named volume `mariadb_data`, so the database is not deleted on a regular container restart or `docker-compose down`.

If you run `docker-compose down -v`, the volume will be deleted too, and the database will be recreated from the init scripts on the next start.

## 4. Database backup and restore

Backup:

`docker-compose exec -T mariadb mariadb-dump -uroot -p${DB_ROOT_PASSWORD} ${DB_NAME} > database/backups/mvc_dump.sql`

Restore:

`docker-compose exec -T mariadb mariadb -uroot -p${DB_ROOT_PASSWORD} ${DB_NAME} < database/backups/mvc_dump.sql`

## 5. Deploy on another device

1. Clone the repository.
2. Check the `.env` file values.
3. Install PHP dependencies for the application:

`cd data && composer install`

4. Return to the project root and start containers:

`docker-compose up -d --build`

After that the application code is installed from Packagist through Composer, and the database is created automatically from `database/init/01-init.sql`.

## PS Based on original image by https://github.com/jurapro/apache-php-mysql-node
