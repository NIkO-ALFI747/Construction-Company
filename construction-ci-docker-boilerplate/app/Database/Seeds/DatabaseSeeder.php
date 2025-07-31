<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Database\RawSql;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        error_log("Connected to database. DB object class: " . get_class($db)); // Diagnostic: Print DB object class

        error_log("Checking if 'users' table exists...");
        try {
            $tableExists = false;
            if (method_exists($db, 'tableExists')) {
                // Preferred method if available
                $tableExists = $db->tableExists('users');
                error_log("Using native tableExists() method.");
            } else {
                // Fallback: Manually check for table existence if method is missing
                error_log("Warning: tableExists() method not found on DB object. Falling back to manual check.");
                try {
                    $query = $db->query(new RawSql("SHOW TABLES LIKE 'users'"));
                    $tableExists = $query->getNumRows() > 0;
                    error_log("Manual check query: SHOW TABLES LIKE 'users'");
                } catch (\Exception $e) {
                    error_log("ERROR: Manual table existence check failed: " . $e->getMessage());
                    throw $e; // Re-throw if even manual check fails
                }
            }

            if ($tableExists) {
                error_log("Table 'users' already exists. Database is likely initialized.");
                return;
            }
        } catch (\Exception $e) {
            error_log("ERROR: Failed to check for 'users' table existence: " . $e->getMessage());
            if ($db && method_exists($db, 'getLastQuery')) {
                error_log("Last executed query: " . $db->getLastQuery());
            } else {
                error_log("Could not retrieve last query (DB object or method not available).");
            }
            error_log("This might indicate a deeper issue with the database connection or permissions, or a corrupted framework installation.");
            throw $e;
        }

        error_log("Table 'users' not found. This indicates the automatic import from 'my_db.sql' might not have run or failed, or the seeder is running before the import is complete.");
        error_log("Please check the 'db' service logs for errors during initialization (docker-compose logs db).");

        throw new \Exception("Database tables not found. Automatic import might have failed. Check Docker logs.");
    }
}
