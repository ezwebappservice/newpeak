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

// Contact (legacy URL)
$routes->get('connect', 'Contact::connect');
$routes->post('connect/send-email', 'Contact::send_email');
$routes->post('contact/send_email', 'Contact::send_email');
$routes->post('home/send_email', 'Home::send_email');
$routes->post('newsletter/send', 'Newsletter::send');

// E-commerce routes
$routes->get('shop', 'Shop::index');
$routes->get('shop/category/(:segment)', 'Shop::category/$1');
$routes->get('shop/subcategory/(:segment)', 'Shop::subcategory/$1');
$routes->get('shop/product/(:segment)', 'Shop::product/$1');
$routes->match(['get', 'post'], 'shop/search', 'Shop::search');
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->get('cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('cart/clear', 'Cart::clear');

$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->get('logout', 'Auth::logout');
$routes->match(['get', 'post'], 'checkout', 'Checkout::index');
$routes->get('checkout/success', 'Checkout::success');

$routes->get('latest-news', 'News::latestNews');
$routes->get('latest-news/(:segment)', 'News::detail/$1');
$routes->get('leadership-at-srl', 'Team::leadership');

$routes->get('oncology-products', 'Products::oncology');
$routes->get('non-oncology-products', 'Products::nonOncology');

$shivalikPages = config(\Config\ShivalikPages::class);
foreach ($shivalikPages->slugs as $slug) {
    $routes->get($slug, 'Page::index/' . $slug);
}
$routes->add('page/(:any)', 'Page::index/$1');

$routes->get('investor-relations', 'Investor::index');
$routes->get('investor-relations/category/(:segment)', 'Investor::category/$1');
$routes->get('investor-relations/documents/(:segment)', 'Investor::documents/$1');
$routes->get('investor/documents', 'Investor::documents_api');
$routes->get('investor/years', 'Investor::years');
$routes->get('investor/subcategories', 'Investor::subcategories');
$routes->get('investor/document_types', 'Investor::document_types');
$routes->get('investor/download/(:num)', 'Investor::download/$1');
$routes->get('investor/view/(:num)', 'Investor::view/$1');

$routes->get('api/investor/categories', 'Api\Investor::categories');
$routes->get('api/investor/subcategories', 'Api\Investor::subcategories');
$routes->get('api/investor/years', 'Api\Investor::years');
$routes->get('api/investor/document-types', 'Api\Investor::document_types');
$routes->get('api/investor/documents', 'Api\Investor::documents');
$routes->get('api/investor/download/(:num)', 'Api\Investor::download/$1');
$routes->get('api/investor/view/(:num)', 'Api\Investor::view/$1');
