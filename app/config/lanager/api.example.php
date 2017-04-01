<?php

return [

	/*
	 * 'origins'
	 * Set the CORS allowed origin domains here
	 * null disables CORS access
	 */
		'origins' => null,

	/*
	 * 'methods'
	 * Set the allowed CORS methods here
	 * defaults to only allow GET and OPTIONS XSS
	 */

		'methods' => 'GET, OPTIONS',


	/*
	 * 'credentials'
	 * Set the Allow-Credentials header
	 * Use string not bool
	 */  
		'credentials' => 'false',

	];


?>
