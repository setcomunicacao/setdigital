<?php if (!defined('FW')) die('Forbidden');

$manifest = array();

$manifest['id']           = 'retouch';
$manifest['name']         = __('Retouch', 'fw');
$manifest['uri']          = 'http://darwinthemes.com';
$manifest['description']  = __('Another awesome wordpress theme', 'fw');
$manifest['version']      = '1.0';
$manifest['author']       = 'DarwinThemes';
$manifest['author_uri']   = 'http://darwinthemes.com';
$manifest['requirements'] = array(
    'wordpress' => array(
        'min_version' => '4.0',
    )
);

$manifest['supported_extensions'] = array(
    'sidebars' => array(),
    'portfolio' => array(),
    'page-builder' => array(),
    'backup' => array(),
    'seo' => array(),
    'social' => array()
);