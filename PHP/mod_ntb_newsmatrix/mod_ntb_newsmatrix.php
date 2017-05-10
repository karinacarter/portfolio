<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$matrix = modNTB_NewsMatrixHelper::getMatrix($params);

$class_sfx = $params->get('moduleclass_sfx', '');
$matrix_cols = trim($params->get('cols'), 3);

require JModuleHelper::getLayoutPath('mod_ntb_newsmatrix');