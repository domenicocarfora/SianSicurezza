<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Item_everywhere_api
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2021 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Controller\BaseController;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Item_everywhere_api', JPATH_COMPONENT);
//JLoader::register('Item_everywhere_apiController', JPATH_COMPONENT . '/controller.php');


// Execute the task.

$controller = JControllerLegacy::getInstance('Item_everywhere_api');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
