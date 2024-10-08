<?php
require_once __DIR__ . '/lib/related-items-lib.php';

return [
	'plugin' => [
		'name' => 'Related Items',
		'version' => '6.0',
		'dependencies' => [],
	],
	'bootstrap' => RelatedItems::class,
	'routes' => [
		'collection:object:related' => [
			'path' => '/related/{guid}',
			'resource' => 'related/default',
		],
	]
];
