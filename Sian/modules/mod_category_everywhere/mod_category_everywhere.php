<?php
/**
 * @copyright	Copyright © 2020 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
require_once dirname(__FILE__).'/helper.php';
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_category_everywhere/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_category_everywhere/assets/js/script.js");
// $width 			= $params->get("width");

$categorie = modCategoryEverywhereHelper::getCategories($params);
//var_dump($params);exit();
if ($params->get('tutte')=='1'){
    require JModuleHelper::getLayoutPath('mod_category_everywhere', $params->get('layout', 'categorie'));
} else {
require JModuleHelper::getLayoutPath('mod_category_everywhere', $params->get('layout', 'default'));}