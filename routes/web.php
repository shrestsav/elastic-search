<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/test',function(){
	return view('test');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['role:superAdmin']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});

Route::get('/elastic', function () {   
        $client = Elasticsearch\ClientBuilder::create()->build();
        return $client;
});

Route::get('/enter/{age}/{name}',function($age,$name){
$client = Elasticsearch\ClientBuilder::create()->build();	//connect with the client
$params = array();
$params['body']  = array(	
  'name' => $name, 											//preparing structred data
  'age' => $age
  
);
$params['index'] = 'beyblade';
$params['type']  = 'beyblade_owner';
$result = $client->index($params);							//using Index() function to inject the data
return $result;
});


Route::get('find/{age}',function($age){
$client = Elasticsearch\ClientBuilder::create()->build();		//connect to the client
// $params = [
// 	'index' => 'beyblade',
// 	'type'  => 'beyblade_owner',
// 	'body' => [
// 		'query' => [
// 			'match' => [
// 				'name' => $age
// 			]
// 		]
// 	]
// ];

$params = [
	'index' => 'beyblade',
	'type'  => 'beyblade_owner',
	'body' => [
		'query' => [
			'match' => [
				'age' => [
					'query' => $age,
					"fuzziness" => 4
				]
			]
		]
	]
];


// $params['index'] = 'beyblade';						// Preparing Indexed Data
// $params['type'] = 'beyblade_owner';								
// $params['body']['query']['match']['name'] = $age;			//Find data in which age matches given input
$result = $client->search($params);					//Using Search function
return($result);	               					//Printing out result
});