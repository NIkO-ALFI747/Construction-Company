#!/bin/sh
echo "--- Running init.sh (Version 6) ---"

# Set arguments without the problematic SSL flag
DB_ARGS="-h$DATABASE_HOSTNAME -P$DATABASE_PORT -u$DATABASE_USERNAME -p$DATABASE_PASSWORD"

# Function to check if the database is ready
wait_for_db() {
    echo "Waiting for database to be ready..."
    until mariadb $DB_ARGS -e "SELECT 1;"; do
      echo "Connection attempt failed. Retrying..."
      sleep 1
    done
    echo "Database is ready!"
}

# Call the wait function
wait_for_db

# Now that the database is ready, import the SQL dump
echo "Importing SQL dump into the database..."
mariadb $DB_ARGS "$DATABASE_DATABASE" < construction_db.sql

if [ $? -eq 0 ]; then
    echo "SQL dump imported successfully!"
else
    echo "ERROR: Failed to import SQL dump. Check your credentials and firewall settings."
    exit 1
fi