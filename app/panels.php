<?php

namespace Ranalytics;

if (!defined('HERBERT_AUTOLOAD')) {
	exit;
}
// Exit if accessed directly

/** @var \Herbert\Framework\Panel $panel */
$panel->add([
	'type'  => 'panel',
	'as'    => 'mainPanel',
	'title' => 'Analytics',
	'slug'  => 'ranalytics-index',
	'icon'  => 'dashicons-chart-bar',
	'uses'  => __NAMESPACE__ . '\\Controllers\\Analytics@Index',
]);

$panel->add([
	'type'   => 'sub-panel',
	'parent' => 'mainPanel',
	'as'     => 'roleSetup',
	'title'  => 'Settings',
	'slug'   => 'ranalytics-roles',

	'uses'   => __NAMESPACE__ . '\\Controllers\\Analytics@roleSetup',
]);

$panel->add([
	'type'   => 'sub-panel',
	'parent' => 'mainPanel',
	'as'     => 'configure',
	'title'  => 'Setup',
	'slug'   => 'ranalytics-configure',
	'uses'   => __NAMESPACE__ . '\\Controllers\\Analytics@Configure',
]);
