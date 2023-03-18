# Covid19-ChallengeTask
Covid19-Task
This is a Laravel project that uses Docker to run. This project was created to 
Requirements
* Docker
* Docker Compose
Getting Started
1. Clone the repository
bash

Copy code
git clone https://github.com/<your-username>/covid19-Task.git
2. Navigate into the project directory
bash

Copy code
cd covid19-Task
3. Build the Docker containers

Copy code
docker-compose build
4. Start the Docker containers

Copy code
docker-compose up -d
5. Create a copy of the .env file and modify the necessary configurations
bash

Copy code
cp .env.example .env
6. Update the .env file to include the database details:
makefile

Copy code
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=covid19-db
DB_USERNAME=root
DB_PASSWORD=password
7. Install the dependencies
python

Copy code
docker-compose exec app composer install
8. Generate the application key
python

Copy code
docker-compose exec app php artisan key:generate
9. Run the migrations
python

Copy code
docker-compose exec app php artisan migrate
10. Access the application by opening a web browser and entering the URL:
javascript

Copy code
http://localhost:<port-number>
Contributing
If you want to contribute to this project, please follow the contributing guidelines.
License
This project is licensed under the [insert license type] license. See the LICENSE file for details.
Acknowledgments
* [insert any acknowledgments you want to give]

