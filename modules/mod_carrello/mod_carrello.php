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
$doc->addStyleSheet(JURI::root()."modules/mod_carrello/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_carrello/assets/js/script.js");
// $width 			= $params->get("width");

$carrello = modCarrelloHelper::getcarrello($params);
require JModuleHelper::getLayoutPath('mod_carrello', $params->get('layout', 'default'));