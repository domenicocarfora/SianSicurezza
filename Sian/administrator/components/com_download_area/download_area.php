<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Download_area
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2020 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_download_area'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Download_area', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Download_areaHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'download_area.php');

$controller = BaseController::getInstance('Download_area');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
