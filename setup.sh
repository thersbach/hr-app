# complete setup. Start docker-compose build, run, start symfony and in
# the frontend directory start yarn start

# Start docker-compose
docker-compose up -d

# wait till there is a connection possible to port 3306 and it is possible to get a status from mariadb
while ! nc -z 127.0.0.1 3306; do
  sleep 0.1
done

while ! docker exec -i mariadb mariadb -u root -prootpassword -e "status"; do
  sleep 5
done

# install composer
composer install

# Start symfony
php bin/console doctrine:migrations:migrate -n
symfony server:start -d

# Start yarn
cd frontend
yarn install
yarn start

# go back to the root directory
cd ..
