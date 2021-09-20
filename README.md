# Mocknet

Mocknet is a light weight replica of the scoutnet api using fake data for testing environment.

## Installation

Install the package using composer with `composer require klako/mocknet`

The package requires some database that is compatible with Doctrine, such as sqlite or mysql. Parameters for creating a database connection can be found in the [doctrine docs](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.13/reference/configuration.html#configuration)

## Running the app

There are three ways to run the app.

### Using [`Scouterna\Mocknet\PhpServer`](src/PhpServer.php)

The following code will start an internal php web server on the host's specified address and port.

```PHP
$server = new Scouterna\Mocknet\PhpServer(
    "localhost",
    "8080",
    $databaseParams, // parameters for the database connection as specified above
    444, // The group id to be required in the api calls
    "abcdefghikjlmn" // The api key to be required in the api calls
);
$server->start();
```

### Using [`Scouterna\Mocknet\ServerApp`](src/ServerApp.php)

The following code will run the app if you want to run it programmatically within your existing one.
```PHP
Scouterna\Mocknet\ServerApp::run(
    $connection, // A Doctrine\DBAL\Connection or parameters for the database connection
    444, // The group id to be required in the api calls
    "abcdefghikjlmn" // The api key to be required in the api calls
);
```

### Using [server.php](src/server.php)

The server.php file can be used as an entry point for a web server.

The following environment variables must be specified.

- `MOCKNET_VENDOR_FOLDER` Path to the composer vendor folder
- `MOCKNET_DBPARAMS` A base64 encoded json object with the database parameters
- `MOCKNET_GROUP_ID` The group id to be required in the api calls
- `MOCKNET_API_KEY` The api key to be required in the api calls

## Generating and reading the database

In order to simply generate a group, run the [generator.php](src/generator.php) file with the following environment variables.
- `MOCKNET_VENDOR_FOLDER` Path to the composer vendor folder
- `MOCKNET_DBPARAMS` A base64 encoded json object with the database parameters
- `MOCKNET_GROUP_ID` The group id of the generated group

In order to create a manager for reading as well as writing to the database, use the `Scouterna\Mocknet\Database\ManagerFactory` class. The namespace `Scouterna\Mocknet\Database\Model` contains all entities that are used by the manager and the api.
