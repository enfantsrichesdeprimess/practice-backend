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

## PS Based on original image by https://github.com/jurapro/apache-php-mysql-node