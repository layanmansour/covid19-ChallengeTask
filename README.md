# Covid19-ChallengeTask
This project is built using Laravel, VueJS and Docker, and it requires Docker and Docker Compose to be installed on your system in order to run.

### Requirements
* Docker
* Docker Compose

### Installation
1 * Clone the project repository:

```
git clone https://github.com/layanmansour/covid19-ChallengeTask
```

2 * Navigate to the project directory:

```
cd covid19-ChallengeTask-main
```
3 * Start the Docker containers using Docker Compose:

```
docker-compose up -d
```

4 * Run the migrations and seed the database:

```
docker-compose exec backend php artisan migrate --seed
```
5 * Running The Queue Worker
```
docker exec -it backend php artisan queue:work
```

### Usage

You can access the project in your web browser at http://localhost:8081 for frontend.The backend http://localhost:8000. Database http://localhost:8080

To access the database, you can use the following credentials:

* Host: db
* Port: 3306
* Database Name: covid19_db
* Username: root
* Password: root

### Stopping the application

To stop the application, simply run the following command:

```
docker-compose down
```

This will stop and remove all containers, networks, and volumes that were created by Docker Compose.


