<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->post('/changePassword', 'Home::changePassword');

// Login
$routes->get('/login', 'Auth::login');
// Action login
$routes->post('/login', 'Auth::login');

// Logout
$routes->get('/logout', 'Auth::logout');

// Users
$routes->get('/users/manage', 'Users::manage', ["filter" => "authenticate"]);
$routes->get('/users/readColumn', 'Users::readColumn');
$routes->post('/users/grid', 'Users::grid');
$routes->get('/users/getJson', 'Users::getJson');
$routes->post('/users/getJson', 'Users::getJson');
$routes->get('/users/formUsers', 'Users::formUsers');
$routes->post('/users/formUsers', 'Users::formUsers');

// $routes->get('/users/updateUsers', 'Users::updateUsers');
$routes->post('/users/updateUsers', 'Users::updateUsers');
$routes->post('/users/createUsers', 'Users::createUsers');
// $routes->get('/users/createUsers', 'Users::createUsers');
$routes->post('/users/deleteUsers', 'Users::deleteUsers');
// Groups
$routes->post('/groups/combogridGroups', 'Groups::combogridGroups');
$routes->post('/groups/combogridGroups/(:any)', 'Groups::combogridGroups/$1');

$routes->get('/groups/manage', 'Groups::manage');
// $routes->get('/groups/getJson', 'Groups::getJson');
$routes->post('/groups/getJson', 'Groups::getJson');
$routes->get('/groups/formGroups', 'Groups::formGroups');
$routes->post('/groups/formGroups', 'Groups::formGroups');
// $routes->get('/groups/updateGroups', 'Groups::updateGroups');
$routes->post('/groups/updateGroups', 'Groups::updateGroups');
$routes->post('/groups/createGroups', 'Groups::createGroups');
// $routes->get('/groups/createGroups', 'Groups::createGroups');
$routes->post('/groups/deleteGroups', 'Groups::deleteGroups');

// Representatives
$routes->get('/representatives/manage', 'Representatives::manage');
// $routes->get('/representatives/getJson', 'Representatives::getJson');
$routes->post('/representatives/getJson', 'Representatives::getJson');
$routes->get('/representatives/formRepresentatives', 'Representatives::formRepresentatives');
$routes->post('/representatives/formRepresentatives', 'Representatives::formRepresentatives');
// $routes->get('/representatives/updateRepresentatives', 'Representatives::updateRepresentatives');
$routes->post('/representatives/updateRepresentatives', 'Representatives::updateRepresentatives');
$routes->post('/representatives/createRepresentatives', 'Representatives::createRepresentatives');
// $routes->get('/representatives/createRepresentatives', 'Representatives::createRepresentatives');
$routes->post('/representatives/deleteRepresentatives', 'Representatives::deleteRepresentatives');

// Permissions
$routes->get('/perm/manage', 'Perm::manage');
// $routes->get('/perm/getJson/(:any)', 'Perm::getJson/$1');
$routes->post('/perm/getJson/(:any)', 'Perm::getJson/$1');
$routes->post('/perm/getJson', 'Perm::getJson');
$routes->post('/perm/updateId/(:any)', 'Perm::updateId/$1');
$routes->post('/perm/copyGroups', 'Perm::copyGroups');

// Menu
$routes->get('/menu/manage', 'Menu::manage');
$routes->get('/menu/manage/(:any)', 'Menu::manage/$1');
$routes->get('/menu/onloadMenu/(:any)', 'Menu::onloadMenu/$1');
// $routes->post('/menu/onloadMenu/(:any)', 'Menu::onloadMenu/$1');
$routes->get('/menu/addMenu/(:any)', 'Menu::addMenu/$1');
// $routes->post('/menu/addMenu/(:any)', 'Menu::addMenu/$1');
$routes->post('/menu/getIconMenu', 'Menu::getIconMenu');
$routes->post('/menu/menuSave', 'Menu::menuSave');
$routes->get('/menu/editMenu/(:any)', 'Menu::editMenu/$1');
$routes->post('/menu/deleteMenu', 'Menu::deleteMenu');
$routes->post('/menu/updateMenu', 'Menu::updateMenu');

// LogLogin
$routes->get('/logLogin/manage', 'LogLogin::manage');
// $routes->get('/logLogin/getJson', 'LogLogin::getJson');
$routes->post('/logLogin/getJson', 'LogLogin::getJson');

// Customers
$routes->get('/customers/manage', 'Customers::manage');
// $routes->get('/customers/getJson', 'Customers::getJson');
$routes->post('/customers/getJson', 'Customers::getJson');
$routes->post('/customers/createCustomers', 'Customers::createCustomers');
$routes->post('/customers/deleteCustomers', 'Customers::deleteCustomers');
$routes->get('/customers/updatecustomers', 'Customers::updatecustomers');
$routes->post('/customers/updatecustomers', 'Customers::updatecustomers');
$routes->get('/customers/formCustomers', 'Customers::formCustomers');

// Products
$routes->get('/products/manage', 'Products::manage');
// $routes->get('/products/getJson', 'Products::getJson');
$routes->post('/products/getJson', 'Products::getJson');
$routes->post('/products/getJsonLocationStock(:any)', 'Products::getJsonLocationStock/$1');
$routes->get('/products/formProducts/(:any)', 'Products::formProducts/$1');
$routes->get('/products/viewProducts/(:any)', 'Products::viewProducts/$1');
// $routes->post('/products/formProducts', 'Products::formProducts');
$routes->post('/products/deleteProducts', 'Products::deleteProducts');
$routes->post('/products/createProducts', 'Products::createProducts');
$routes->post('/products/updateProducts', 'Products::updateProducts');
$routes->get('/products/viewLocationStock', 'Products::viewLocationStock');

// Locations
$routes->get('/locations/manage', 'Locations::manage');
// $routes->get('/locations/getJson', 'Locations::getJson');
$routes->post('/locations/getJson', 'Locations::getJson');
$routes->post('/locations/getJsonLocationProducts', 'Locations::getJsonLocationProducts');
$routes->get('/locations/formLocations', 'Locations::formLocations');
$routes->get('/locations/formAdjustments', 'Locations::formAdjustments');
$routes->post('/locations/deleteLocations', 'Locations::deleteLocations');
$routes->post('/locations/createLocations', 'Locations::createLocations');
$routes->post('/locations/createAdjustments', 'Locations::createAdjustments');
$routes->post('/locations/updateLocations', 'Locations::updateLocations');

// LocationTransfers
$routes->get('/locationtransfers/manage', 'LocationTransfers::manage');
$routes->post('/locationtransfers/getJson', 'LocationTransfers::getJson');
$routes->get('/locationtransfers/getJsonDetails', 'LocationTransfers::getJsonDetails');
$routes->post('/locationtransfers/getJsonDetails', 'LocationTransfers::getJsonDetails');
$routes->get('/locationtransfers/formLocationTransfers/(:any)', 'LocationTransfers::formLocationTransfers/$1');
$routes->get('/locationtransfers/formLocationTransferDetails/(:any)', 'LocationTransfers::formLocationTransferDetails/$1');
$routes->post('/locationtransfers/createLocationTransfers', 'LocationTransfers::createLocationTransfers');
$routes->post('/locationtransfers/deleteLocationTransfers', 'LocationTransfers::deleteLocationTransfers');
// $routes->post('/locationtransfers/updateLocationTransfers', 'LocationTransfers::updateLocationTransfers');

$routes->post('/locationtransfers/getJsonDetails', 'LocationTransfers::getJsonDetails');
$routes->post('/locationtransfers/getJsonDetailsTemp', 'LocationTransfers::getJsonDetailsTemp');
$routes->post('/locationtransfers/createLocationTransferDetails/(:any)', 'LocationTransfers::createLocationTransferDetails/$1');
$routes->post('/locationtransfers/deleteLocationTransferDetails/(:any)', 'LocationTransfers::deleteLocationTransferDetails/$1');
$routes->post('/locationtransfers/updateLocationTransferDetails/(:any)', 'LocationTransfers::updateLocationTransferDetails/$1');

// SalesOrders
$routes->get('/salesorders/manage', 'SalesOrders::manage');
// $routes->get('/salesorders/getJson', 'SalesOrders::getJson');
$routes->post('/salesorders/getJson', 'SalesOrders::getJson');
$routes->get('/salesorders/getJsonDetailsTemp', 'SalesOrders::getJsonDetailsTemp');
$routes->post('/salesorders/getJsonDetailsTemp', 'SalesOrders::getJsonDetailsTemp');
$routes->get('/salesorders/getJsonDetails', 'SalesOrders::getJsonDetails');
$routes->post('/salesorders/getJsonDetails', 'SalesOrders::getJsonDetails');
// $routes->get('/salesorders/formSalesOrders/(:any)', 'SalesOrders::formSalesOrders/$1');
// $routes->get('/salesorders/viewSalesOrders/(:any)', 'SalesOrders::viewSalesOrders/$1');
$routes->get('/salesorders/formSalesOrders/(:any)', 'SalesOrders::formSalesOrders/$1');
$routes->post('/salesorders/formSalesOrders', 'SalesOrders::formSalesOrders');
$routes->get('/salesorders/formSalesOrdersDetails/(:any)', 'SalesOrders::formSalesOrdersDetails/$1');
$routes->post('/salesorders/formSalesOrdersDetails/(:any)', 'SalesOrders::formSalesOrdersDetails/$1');
$routes->post('/salesorders/deleteSalesOrders', 'SalesOrders::deleteSalesOrders');
$routes->post('/salesorders/createSalesOrders', 'SalesOrders::createSalesOrders');
$routes->post('/salesorders/updateSalesOrders', 'SalesOrders::updateSalesOrders');
$routes->post('/salesorders/cancelSalesOrders', 'SalesOrders::cancelSalesOrders');

$routes->get('/salesorders/pdfSalesOrders/(:any)', 'SalesOrders::pdfSalesOrders/$1');
$routes->post('/salesorders/approvalSalesOrders', 'SalesOrders::approvalSalesOrders');

$routes->get('/salesorders/viewSalesOrders/(:any)', 'SalesOrders::viewSalesOrders/$1');
$routes->post('/salesorders/createSalesOrdersDetails/(:any)', 'SalesOrders::createSalesOrdersDetails/$1');
$routes->post('/salesorders/deleteSalesOrdersDetails/(:any)', 'SalesOrders::deleteSalesOrdersDetails/$1');
$routes->post('/salesorders/updateSalesOrdersDetails/(:any)', 'SalesOrders::updateSalesOrdersDetails/$1');


// PurchaseOrders
$routes->get('/purchaseorders/manage', 'PurchaseOrders::manage');
$routes->get('/purchaseorders/formPurchaseOrders/(:any)', 'PurchaseOrders::formPurchaseOrders/$1');
$routes->post('/purchaseorders/formPurchaseOrders', 'PurchaseOrders::formPurchaseOrders');
// SalesOrdersAamount
$routes->post('/salesordersamount/getJson', 'SalesOrdersAmount::getJson');

// Packages
$routes->get('/packages/manage', 'Packages::manage');
$routes->get('/packages/getJsonDetailsTemp', 'Packages::getJsonDetailsTemp');
$routes->post('/packages/getJsonDetailsTemp', 'Packages::getJsonDetailsTemp');
$routes->get('/packages/formPackages/(:any)', 'Packages::formPackages/$1');
$routes->get('/packages/formPackagesDetails/(:any)', 'Packages::formPackagesDetails/$1');
$routes->post('/packages/createPackagesDetails/(:any)', 'Packages::createPackagesDetails/$1');
$routes->post('/packages/updatePackagesDetails/(:any)', 'Packages::updatePackagesDetails/$1');
$routes->post('/packages/deletePackagesDetails/(:any)', 'Packages::deletePackagesDetails/$1');
$routes->post('/packages/deleteDetailsTempAll', 'Packages::deleteDetailsTempAll');

// DeliveryOrders
$routes->get('/deliveryOrders/manage', 'DeliveryOrders::manage');
$routes->get('/deliveryOrders/getJson', 'DeliveryOrders::getJson');
$routes->post('/deliveryOrders/getJson', 'DeliveryOrders::getJson');

$routes->get('/deliveryOrders/getJsonDetails', 'DeliveryOrders::getJsonDetails');
$routes->post('/deliveryOrders/getJsonDetails', 'DeliveryOrders::getJsonDetails');

$routes->post('/deliveryOrders/approvalDeliveryOrders', 'DeliveryOrders::approvalDeliveryOrders');

$routes->post('/deliveryOrders/createDeliveryOrders', 'DeliveryOrders::createDeliveryOrders');
$routes->post('/deliveryOrders/updateDeliveryOrders', 'DeliveryOrders::updateDeliveryOrders');
$routes->post('/deliveryOrders/deleteDeliveryOrders', 'DeliveryOrders::deleteDeliveryOrders');
$routes->get('/deliveryOrders/getJsonDetailsTemp', 'DeliveryOrders::getJsonDetailsTemp');
$routes->post('/deliveryOrders/getJsonDetailsTemp', 'DeliveryOrders::getJsonDetailsTemp');
$routes->get('/deliveryOrders/formDeliveryOrders/(:any)', 'DeliveryOrders::formDeliveryOrders/$1');
$routes->get('/deliveryOrders/formDeliveryOrdersDetails/(:any)', 'DeliveryOrders::formDeliveryOrdersDetails/$1');
$routes->get('/deliveryOrders/formMarkDelivered/(:any)', 'DeliveryOrders::formMarkDelivered/$1');

$routes->get('/deliveryOrders/viewDeliveryOrders/(:any)', 'DeliveryOrders::viewDeliveryOrders/$1');
$routes->post('/deliveryOrders/createDeliveryOrdersDetails/(:any)', 'DeliveryOrders::createDeliveryOrdersDetails/$1');
$routes->post('/deliveryOrders/updateDeliveryOrdersDetails/(:any)', 'DeliveryOrders::updateDeliveryOrdersDetails/$1');
$routes->post('/deliveryOrders/deleteDeliveryOrdersDetails/(:any)', 'DeliveryOrders::deleteDeliveryOrdersDetails/$1');
$routes->post('/deliveryOrders/deleteDetailsTempAll', 'DeliveryOrders::deleteDetailsTempAll');
$routes->post('/deliveryOrders/markAsDelivered', 'DeliveryOrders::MarkAsDelivered');
$routes->post('/deliveryOrders/markAsUndeliveryOrders', 'DeliveryOrders::MarkAsUndeliveryOrders');
$routes->post('/deliveryOrders/cancelDeliveryOrders', 'DeliveryOrders::CancelDeliveryOrders');

// Shipments
$routes->get('/shipments/manage', 'Shipments::manage');

// Combogrid
// $routes->get('/combogrid/combogridPaymentTerms', 'Combogrid::combogridPaymentTerms');
$routes->post('/combogrid/combogridSalesOrderToPackage', 'Combogrid::combogridSalesOrderToPackage');
$routes->get('/combogrid/combogridSalesOrderToPackage', 'Combogrid::combogridSalesOrderToPackage');
$routes->post('/combogrid/combogridSalesOrderToDelivery', 'Combogrid::combogridSalesOrderToDelivery');
$routes->get('/combogrid/combogridSalesOrderToDelivery', 'Combogrid::combogridSalesOrderToDelivery');
$routes->post('/combogrid/combogridPaymentTerms', 'Combogrid::combogridPaymentTerms');
$routes->post('/combogrid/combogridCustomerStatus/(:any)', 'Combogrid::combogridCustomerStatus/$1');
$routes->post('/combogrid/combogridLocations', 'Combogrid::combogridLocations');
$routes->get('/combogrid/combogridLocations', 'Combogrid::combogridLocations');
$routes->post('/combogrid/combogridUnit', 'Combogrid::combogridUnit');
$routes->get('/combogrid/combogridUnit', 'Combogrid::combogridUnit');
$routes->post('/combogrid/combogridCustomer/(:any)', 'Combogrid::combogridCustomer/$1');
$routes->post('/combogrid/combogridCustomer', 'Combogrid::combogridCustomer');
$routes->get('/combogrid/combogridCustomer', 'Combogrid::combogridCustomer');
$routes->post('/combogrid/combogridRepresentative', 'Combogrid::combogridRepresentative');
$routes->get('/combogrid/combogridProductsSalesOrdersDetails/(:any)', 'Combogrid::combogridProductsSalesOrdersDetails/$1');
$routes->post('/combogrid/combogridProductsSalesOrdersDetails/(:any)', 'Combogrid::combogridProductsSalesOrdersDetails/$1');
$routes->get('/combogrid/combogridProductsByStockLocation', 'Combogrid::combogridProductsByStockLocation');
$routes->post('/combogrid/combogridProductsByStockLocation', 'Combogrid::combogridProductsByStockLocation');
$routes->get('/combogrid/combogridProducts', 'Combogrid::combogridProducts');
$routes->post('/combogrid/combogridProducts', 'Combogrid::combogridProducts');
$routes->post('/combogrid/combogridProductsToPackage', 'Combogrid::combogridProductsToPackage');
$routes->post('/combogrid/combogridProductsToShipment/(:any)', 'Combogrid::combogridProductsToShipment/$1');
$routes->post('/combogrid/combogridSalesOrderStatus/(:any)', 'Combogrid::combogridSalesOrderStatus/$1');
$routes->post('/combogrid/combogridDeliveryOrderStatus/(:any)', 'Combogrid::combogridDeliveryOrderStatus/$1');
$routes->post('/combogrid/combogridProductType/(:any)', 'Combogrid::combogridProductType/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
