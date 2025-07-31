<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    public array $default = []; // Initialize as empty array or with static defaults

    //    /**
    //     * Sample database connection for SQLite3.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'database'    => 'database.db',
    //        'DBDriver'    => 'SQLite3',
    //        'DBPrefix'    => '',
    //        'DBDebug'     => true,
    //        'swapPre'     => '',
    //        'failover'    => [],
    //        'foreignKeys' => true,
    //        'busyTimeout' => 1000,
    //        'dateFormat'  => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for Postgre.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => '',
    //        'hostname'   => 'localhost',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'database'   => 'ci4',
    //        'schema'     => 'public',
    //        'DBDriver'   => 'Postgre',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'utf8',
    //        'swapPre'    => '',
    //        'failover'   => [],
    //        'port'       => 5432,
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for SQLSRV.
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => '',
    //        'hostname'   => 'localhost',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'database'   => 'ci4',
    //        'schema'     => 'dbo',
    //        'DBDriver'   => 'SQLSRV',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'utf8',
    //        'swapPre'    => '',
    //        'encrypt'    => false,
    //        'failover'   => [],
    //        'port'       => 1433,
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    //    /**
    //     * Sample database connection for OCI8.
    //     *
    //     * You may need the following environment variables:
    //     *   NLS_LANG                = 'AMERICAN_AMERICA.UTF8'
    //     *   NLS_DATE_FORMAT         = 'YYYY-MM-DD HH24:MI:SS'
    //     *   NLS_TIMESTAMP_FORMAT    = 'YYYY-MM-DD HH24:MI:SS'
    //     *   NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS'
    //     *
    //     * @var array<string, mixed>
    //     */
    //    public array $default = [
    //        'DSN'        => 'localhost:1521/XEPDB1',
    //        'username'   => 'root',
    //        'password'   => 'root',
    //        'DBDriver'   => 'OCI8',
    //        'DBPrefix'   => '',
    //        'pConnect'   => false,
    //        'DBDebug'    => true,
    //        'charset'    => 'AL32UTF8',
    //        'swapPre'    => '',
    //        'failover'   => [],
    //        'dateFormat' => [
    //            'date'     => 'Y-m-d',
    //            'datetime' => 'Y-m-d H:i:s',
    //            'time'     => 'H:i:s',
    //        ],
    //    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // --- DIAGNOSTIC: Check DBDriver value from getenv() ---
        $dbDriverEnv = getenv('database.default.DBDriver');
        error_log("DEBUG: database.default.DBDriver from getenv(): " . ($dbDriverEnv === false ? 'false (not set)' : (empty($dbDriverEnv) ? 'empty string' : $dbDriverEnv)));

        // Enable all error reporting and logging for this class
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);

        // --- DEBUGGING DATABASE VALUES ---
        $dsn_env = getenv('DATABASE_DSN');
        $hostname_env = getenv('DATABASE_HOSTNAME');
        $username_env = getenv('DATABASE_USERNAME');
        $password_env = getenv('DATABASE_PASSWORD');
        $database_env = getenv('DATABASE_DATABASE');
        $dbdriver_env = getenv('DATABASE_DBDRIVER');
        $port_env = getenv('DATABASE_PORT');
        $charset_env = getenv('DATABASE_CHARSET');
        $dbcollat_env = getenv('DATABASE_DBCOLLAT');
        $swappre_env = getenv('DATABASE_SWAPPRE');
        $app_debug_env = getenv('APP_DEBUG');

        error_log("DEBUG DB: APP_DEBUG from getenv(): " . ($app_debug_env === false ? 'false' : $app_debug_env));
        error_log("DEBUG DB: DSN from getenv(): " . ($dsn_env === false ? 'false' : $dsn_env));
        error_log("DEBUG DB: Hostname from getenv(): " . ($hostname_env === false ? 'false' : $hostname_env));
        error_log("DEBUG DB: Username from getenv(): " . ($username_env === false ? 'false' : $username_env));
        error_log("DEBUG DB: Password from getenv(): " . ($password_env === false ? 'false' : $password_env));
        error_log("DEBUG DB: Database from getenv(): " . ($database_env === false ? 'false' : $database_env));
        error_log("DEBUG DB: DBDriver from getenv(): " . ($dbdriver_env === false ? 'false' : $dbdriver_env));
        error_log("DEBUG DB: Port from getenv(): " . ($port_env === false ? 'false' : $port_env));
        error_log("DEBUG DB: Charset from getenv(): " . ($charset_env === false ? 'false' : $charset_env));
        error_log("DEBUG DB: DBCollat from getenv(): " . ($dbcollat_env === false ? 'false' : $dbcollat_env));
        error_log("DEBUG DB: SwapPre from getenv(): " . ($swappre_env === false ? 'false' : $swappre_env));

        // Assign values from environment variables in the constructor
        $this->default = [
            'DSN'      => $dsn_env ?? 'mysql:host=localhost;dbname=ci4',
            'hostname' => $hostname_env ?? 'localhost',
            'username' => $username_env ?? 'root',
            'password' => $password_env ?? '',
            'database' => $database_env ?? 'ci4',
            'DBDriver' => $dbdriver_env ?? 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT === 'development' || ($app_debug_env === 'true')),
            'charset'  => $charset_env ?? 'utf8mb4',
            'DBCollat' => $dbcollat_env ?? 'utf8mb4_general_ci',
            'swapPre'  => $swappre_env ?? '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => (int) ($port_env ?? 3306),
            'numberNative' => false,
            'dateFormat'   => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
        ];

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
