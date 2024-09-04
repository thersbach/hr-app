# hr-app

To start the app, run the following command:

```bash
./setup.sh
```

This will install the necessary dependencies and start the app.

Used technologies:
- [React](https://reactjs.org/)
- [Symfony](https://symfony.com/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [MariaDB](https://mariadb.org/)

The app is divided into two parts:
- `frontend` - React app

After setup is complete, a browser window will be opened with the app running at [http://localhost:3000](http://localhost:3000).

The data is being preloaded via migrations.

When the window opens, a table disappears with all the employees and their data. To run an export, press the button on the bottom of the table.

This will fire a request to a Symfony endpoint, which will first calculate all data, store it in the database, and return a CSV file with the data.
