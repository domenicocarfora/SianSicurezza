<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Carrello_api
 * @author      <>
 * @copyright  
 * @license    
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Controller\BaseController;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Carrello_api', JPATH_COMPONENT);
JLoader::register('Carrello_apiController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = BaseController::getInstance('Carrello_api');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
