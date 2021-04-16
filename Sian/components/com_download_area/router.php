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

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class Download_areaRouter
 *
 */
class Download_areaRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_download_area')->params;
		$this->noIDs = (bool) $params->get('sef_ids');
		
		

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		else
		{
			JLoader::register('Download_areaRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('Download_areaHelpersDownload_area', __DIR__ . '/helpers/download_area.php');
			$this->attachRule(new Download_areaRulesLegacy($this));
		}
	}


	

	
}
