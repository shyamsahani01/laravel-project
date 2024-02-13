<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'erpnext' => [
            'driver' => 'mysql',
            // 'host' => '10.200.20.160',
            'host' => '10.200.20.161',
            'database' => '_1bd3e0294da19198',
            'username' => 'erpnextuser',
            'password' => 'Admin@123',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        'erpnextLocal' => [
            'driver' => 'mysql',
            'host' => '10.200.20.161',
            'database' => '_1bd3e0294da19198',
            'username' => 'erpnextuser',
            'password' => 'Admin@123',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        // 'erpnext' => [
        //     'driver' => 'mysql',
        //     'host' => '10.201.10.160',
        //     'database' => '_1bd3e0294da19198',
        //     'username' => 'erpnextuser',
        //     'password' => 'Admin@123',
        //     'charset' => 'utf8',
        //     'collation' => 'utf8_unicode_ci',
        //     'prefix' => '',
        // ],

        // 'erpnext' => [
        //     'driver' => 'mysql',
        //     'host' => '127.0.0.1',
        //     'port' => '3308',
        //     'database' => '_1bd3e0294da19198',
        //     'username' => 'erpnextuser',
        //     'password' => 'Admin@123',
        //     'charset' => 'utf8',
        //     'collation' => 'utf8_unicode_ci',
        //     'prefix' => '',
        // ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        // 'localdesign' => [
        //     'driver' => 'mysql',
        //     'host' => '192.168.2.159',
        //     'database' => 'reports',
        //     'port' => '3306',
        //     'username' => 'reports',
        //     'password' => 'Yre2#P46Fw',
        //     // 'charset' => 'utf8',
        //     // 'collation' => 'utf8_unicode_ci',
        //     'prefix' => '',
        // ],

        'localdesign' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'reports',
            'port' => '3306',
            'username' => 'pinkcityRoot',
            'password' => 'pcjh@29#KYSP!',
            // 'charset' => 'utf8',
            // 'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        'essl' => [
            'driver' => 'mysql',
            'host' => 'ESSL\\SQLEXPRESS',
            'database' => 'etimetracklite1',
            'username' => 'timesheet',
            'port' => env('DB_PORT', '1433'),
            'password' => 'ts1',
            'encrypt' => 'yes', // alternatively, defer to an env variable
            'trust_server_certificate' => 'true', // alternatively, defer to an env variable
            'prefix' => '',
        ],


        'jade' => [
            'driver' => 'mysql',
            'host' => 'ESSL\\SQLEXPRESS',
            'database' => 'Jade',
            'username' => 'Jade',
            'port' => env('DB_PORT', '1433'),
            'password' => '#8zI7mj7XSG5QMOr',
            'encrypt' => 'yes', // alternatively, defer to an env variable
            'trust_server_certificate' => 'true', // alternatively, defer to an env variable
            'prefix' => '',
        ],



        'essl' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => 'ESSL\\SQLEXPRESS',
            'port' => env('DB_PORT', '1433'),
            'database' => 'etimetracklite1',
            'username' => 'timesheet',
            'password' => 'ts1',
            'prefix_indexes' => true,
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'essl\sqlexpress'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'etimetracklite1'),
            'username' => env('DB_USERNAME', 'timesheet'),
            'password' => env('DB_PASSWORD', 'ts1'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],


        'Emr' => array(
            'driver' => 'sqlsrv',
            'host' => '192.168.2.5', // Provide IP address here
            // 'host' => '192.168.5.108', // Provide IP address here
            'database' => 'Emr',
            'username' => 'Dheeraj.Gupta',
            'password' => 'admin@123',
            'prefix' => '',
           ),

        'EmrSitapura' => array(
            'driver' => 'sqlsrv',
            'host' => '192.168.5.88', // Provide IP address here
            // 'host' => '192.168.5.108', // Provide IP address here
            'database' => 'Emr',
            'username' => 'Pankaj.Kumar',
            'password' => 'admin@123',
            'prefix' => '',
           ),

        'EmrMahapura' => array(
            'driver' => 'sqlsrv',
            'host' => '192.168.2.5', // Provide IP address here
            // 'host' => '192.168.5.108', // Provide IP address here
            'database' => 'Emr',
            'username' => 'Dheeraj.Gupta',
            'password' => 'admin@123',
            'prefix' => '',
           ),


        'Attendance' => array(
            'driver' => 'sqlsrv',
            'host' => '192.168.5.110', // Provide IP address here
            'port' => '5555',
            'database' => 'etimetracklite1',
            'username' => 'timesheet',
            'password' => 'ts1',
            'prefix' => '',
           ),

        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_HOST', 'essl\sqlexpress'),
        //     'port' => env('DB_PORT', '1433'),
        //     'database' => env('DB_DATABASE', 'etimetracklite1'),
        //     'username' => env('DB_USERNAME', 'timesheet'),
        //     'password' => env('DB_PASSWORD', 'ts1'),
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
