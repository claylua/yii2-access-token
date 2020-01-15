<?php
return [
	'components' => [
		'jwt' => [
			'class' => \sizeg\jwt\Jwt::class,
			'key' => 'secret',
			// You have to configure ValidationData informing all claims you want to validate the token.
			'jwtValidationData' => claylua\token\components\JwtValidationData::class,
		],
		// list of component configurations
	],
	'params' => [
		// list of parameters
	],
];
