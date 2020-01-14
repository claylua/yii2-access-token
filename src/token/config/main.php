<?php
return [
	'components' => [
		// list of component configurations
		// other default components here..
		'jwt' => [
			'class' => \sizeg\jwt\Jwt::class,
			'key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
			// You have to configure ValidationData informing all claims you want to validate the token.
			'jwtValidationData' => claylua\token\components\JwtValidationData::class,
		],
	],
	'params' => [
		"ISSUSER"=> "",
		"AUDIENCE"=> "",
		"ID"=>"",
		// list of parameters
	],
];
