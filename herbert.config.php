<?php

return [

	/**
	 * The Herbert version constraint.
	 */
	'constraint'   => '~0.9.9',

	/**
	 * Auto-load all required files.
	 */
	'requires'     => [
		__DIR__ . '/app/settings.php',
	],

	/**
	 * The tables to manage.
	 */
	'tables'       => [
	],

	/**
	 * Activate
	 */
	'activators'   => [
	],

	/**
	 * Deactivate
	 */
	'deactivators' => [
		__DIR__ . '/app/deactivate.php',
	],

	/**
	 * The shortcodes to auto-load.
	 */
	'shortcodes'   => [
	],

	/**
	 * The widgets to auto-load.
	 */
	'widgets'      => [
	],

	/**
	 * The styles and scripts to auto-load.
	 */
	'enqueue'      => [
		__DIR__ . '/app/enqueue.php',
	],

	/**
	 * The routes to auto-load.
	 */
	'routes'       => [
		'Ranalytics' => __DIR__ . '/app/routes.php',
	],

	/**
	 * The panels to auto-load.
	 */
	'panels'       => [
		'Ranalytics' => __DIR__ . '/app/panels.php',
	],

	/**
	 * The APIs to auto-load.
	 */
	'apis'         => [
		'RanalyticsApi' => __DIR__ . '/app/api.php',
	],

	/**
	 * The view paths to register.
	 *
	 * E.G: 'Ranalytics' => __DIR__ . '/views'
	 * can be referenced via @Ranalytics/
	 * when rendering a view in twig.
	 */
	'views'        => [
		'Ranalytics' => __DIR__ . '/resources/views',
	],

	/**
	 * The view globals.
	 */
	'viewGlobals'  => [

	],

	/**
	 * The asset path.
	 */
	'assets'       => '/public',

];
