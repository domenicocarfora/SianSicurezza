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
$doc->addStyleSheet(JURI::root()."modules/mod_item_everywhere/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_item_everywhere/assets/js/script.js");
$filter= modItemEverywhereHelper::getFilter($params);
$cat_madre=$params->get('categoria');
if ($params->get('homepage')=='0'){
$items = modItemEverywhereHelper::getItem($params);}
require JModuleHelper::getLayoutPath('mod_item_everywhere', $params->get('layout', 'default'));