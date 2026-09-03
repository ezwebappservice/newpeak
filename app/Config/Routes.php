<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Peak Potential Academy pages
$routes->get('for-parents', 'Programs::parents');
$routes->get('for-school', 'Programs::school');
$routes->get('for-students', 'Programs::students');
$routes->get('for-corporate', 'Programs::corporate');
$routes->get('our-story', 'About::index');
$routes->get('about', 'About::index');
$routes->get('contact-us', 'Contact::index');
$routes->post('contact-us/send', 'Contact::send_email');
$routes->get('customer-enquiry-form', 'Contact::enquiry');
$routes->get('book-a-discovery-call', 'Contact::enquiry');
$routes->post('enquiry/send', 'Contact::send_discovery');
$routes->get('privacy-policy', 'Privacy_policy::index');
$routes->get('terms-and-conditions', 'Terms_and_conditions::index');

// Enable Auto Routing to mimic CodeIgniter 3 behavior
$routes->setAutoRoute(true);

$routes->add('admin', 'Admin\Login::index');
$routes->match(['get', 'post'], 'admin/page-home/edit(:num)', 'Admin\Page_home::edit/$1');
$routes->get('admin/footer-setting', 'Admin\Footer_setting::index');
$routes->get('admin/footer_settings', 'Admin\Footer_setting::index');
$routes->get('admin/footer-settings', 'Admin\Footer_setting::index');



