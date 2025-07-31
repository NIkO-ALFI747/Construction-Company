<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

# --- NEW: Route for database setup ---
$routes->get('/setup/seed', 'Setup::seedDatabase');
