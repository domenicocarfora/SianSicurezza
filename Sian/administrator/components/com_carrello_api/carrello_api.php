<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Carrello_api
 * @author      <>
 * @copyright  
 * @license    
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_carrello_api'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Carrello_api', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Carrello_apiHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'carrello_api.php');

$controller = BaseController::getInstance('Carrello_api');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
