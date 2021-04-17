<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Brandpartner
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2020 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Controller\BaseController;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Brandpartner', JPATH_COMPONENT);
JLoader::register('BrandpartnerController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = BaseController::getInstance('Brandpartner');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
