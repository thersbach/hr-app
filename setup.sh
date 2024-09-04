# complete setup. Start docker-compose build, run, start symfony and in
# the frontend directory start yarn start

# Start docker-compose
docker-compose up -d

# wait till there is a connection possible to port 3306
while ! nc -z localhost 3306; do
  sleep 0.1
done

# Start symfony
php bin/console doctrine:migrations:migrate -n
symfony server:start -d

# Start yarn
cd frontend
yarn install
yarn start

# Start symfony
cd ..
