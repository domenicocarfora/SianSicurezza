<?php
/**
 * @package Helix Ultimate Framework
 * @author ltheme https://www.ltheme.com
 * @copyright Copyright (c) ltheme
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

if (!$this->params->get('comingsoon'))
{
  header("Location: " . \JURI::root());
}

echo JLayoutHelper::render('comingsoon', array('language' => $this->language, 'direction' => $this->direction, 'params' => $this->params));