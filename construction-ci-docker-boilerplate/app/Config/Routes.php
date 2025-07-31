<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomePage::index');

$routes->get('/setup/seed', 'Setup::seedDatabase');

$routes->get('/object_types/creation_page', 'ObjectTypesCreate::index');
$routes->post('/object_types/create', 'ObjectTypesCreate::create');

$routes->get('/object_types/edition_page', 'ObjectTypesEdit::index');
$routes->post('/object_types/edit', 'ObjectTypesEdit::editObjectType');
$routes->post('/object_types/delete', 'ObjectTypesEdit::deleteObjectType');
$routes->post('/object_types/data', 'ObjectTypesEdit::getObjectTypesDataWithId');
$routes->post('/object_types/types', 'ObjectTypesEdit::getObjectTypesData');

$routes->get('/object_types/info_page', 'ObjectTypesInfo::index');
$routes->post('/object_types/filter', 'ObjectTypesInfo::getFilter');
$routes->post('/object_types/search', 'ObjectTypesInfo::getSearch');
$routes->post('/object_types/sort', 'ObjectTypesInfo::getSort');
$routes->post('/object_types/reset', 'ObjectTypesInfo::reset');

$routes->get('/objects/creation_page', 'ObjectsCreate::index');
$routes->post('/objects/create', 'ObjectsCreate::create');

$routes->get('/objects/edition_page', 'ObjectsEdit::index');
$routes->post('/objects/edit', 'ObjectsEdit::editObject');
$routes->post('/objects/delete', 'ObjectsEdit::deleteObject');
$routes->post('/objects/data', 'ObjectsEdit::getObjectData');

$routes->get('/objects/info_page', 'ObjectsInfo::index');
$routes->post('/objects/filter', 'ObjectsInfo::getFilter');
$routes->post('/objects/search', 'ObjectsInfo::getSearch');
$routes->post('/objects/sort', 'ObjectsInfo::getSort');
$routes->post('/objects/reset', 'ObjectsInfo::reset');

$routes->get('/objects/object_names', 'ObjectsInfo::getObjectsDataName');

$routes->get('/schedules/creation_page', 'SchedulesCreate::index');
$routes->post('/schedules/create', 'SchedulesCreate::create');

$routes->get('/schedules/edition_page', 'SchedulesEdit::index');
$routes->post('/schedules/edit', 'SchedulesEdit::editSchedule');
$routes->post('/schedules/delete', 'SchedulesEdit::deleteSchedule');
$routes->post('/schedules/data', 'SchedulesEdit::getSchedulesData');

$routes->get('/schedules/info_page', 'SchedulesInfo::index');
$routes->post('/schedules/filter', 'SchedulesInfo::getFilter');
$routes->post('/schedules/filter_cost', 'SchedulesInfo::getFilterCost');
$routes->post('/schedules/search', 'SchedulesInfo::getSearch');
$routes->post('/schedules/sort', 'SchedulesInfo::getSort');
$routes->post('/schedules/reset', 'SchedulesInfo::reset');

$routes->get('/schedules/brigade_names', 'SchedulesInfo::getBrigadesDataName');

$routes->set404Override();