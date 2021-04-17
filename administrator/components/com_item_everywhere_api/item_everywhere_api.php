<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Item_everywhere_api
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2021 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_item_everywhere_api'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Item_everywhere_api', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Item_everywhere_apiHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'item_everywhere_api.php');

$controller = BaseController::getInstance('Item_everywhere_api');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
