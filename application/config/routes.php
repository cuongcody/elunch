<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['users']['get'] = 'users_api/users';
$route['user/(:num)'] = 'users_api/user/$1';
$route['login']['post'] = 'users_api/login';
$route['logout']['post'] = 'users_api/logout';
$route['register']['post'] = 'users_api/register';
$route['meals'] = 'dishes_api/meals';
$route['table/(:num)/users'] = 'tables_api/users_of_table/$1';
$route['shift/(:num)/tables'] = 'tables_api/tables_of_shift/$1';
$route['tables'] = 'tables_api/tables';
$route['seat'] = 'tables_api/seat';
// User profile api
$route['change_password'] = 'users_api/change_password';
$route['forgot_password'] = 'users_api/forgot_password';
$route['user/(:num)/gcm_regid'] = 'users_api/gcm_regid/$1';
// Votes api
$route['vote'] = 'votes_api/vote';
$route['votes'] = 'votes_api/votes';
$route['user/(:num)/votes'] = 'votes_api/count_vote/$1';
$route['user/(:num)/vote_dishes'] = 'votes_api/vote_dish_of_user/$1';
// Comment api
$route['comment'] = 'comments_api/comment';
$route['reply'] = 'comments_api/reply';
$route['user/(:num)/comment/(:num)'] = 'comments_api/comment/$1/$2';
$route['user/(:num)/comments'] = 'comments_api/comments_of_user/$1';
$route['read_comment'] = 'comments_api/read_comment';
$route['read_replies_comment'] = 'comments_api/read_replies_comment';
// Dishes api
$route['dishes'] = 'dishes_api/dishes';
// Announcement api
$route['user/(:num)/announcements'] = 'announcements_api/announcements/$1';
$route['user/(:num)/announcement/(:num)'] = 'announcements_api/announcement/$1/$2';
$route['announcement']['post'] = 'announcements_api/announcement';
$route['read_announcement'] = 'announcements_api/read_announcement';
$route['read_replies_announcement'] = 'announcements_api/read_replies_announcement';
// Meals
$route['admin/(:any)/(:num)'] = "admin/$1/index/$2";
// Tracking user
$route['user/(:num)/tracking'] = 'tracking_users_api/tracking_user/$1';