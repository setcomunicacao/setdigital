<?php

$cfg = array(
	'sidebar_positions' => array(
		'full' => array(
			'icon_url' => 'full.png',
			'sidebars_number' => 0
		),
		'left' => array(
			'icon_url' => 'left.png',
			'sidebars_number' => 1
		),
		'right' => array(
			'icon_url' => 'right.png',
			'sidebars_number' => 1
		),
	),

	'dynamic_sidebar_args' => array(
		'before_widget' => '<nav id="%1$s" class="nav-a %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '<em class="icon-basic" data-icon="f"></em></h3>',
	),
);