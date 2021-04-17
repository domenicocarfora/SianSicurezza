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

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class Item_everywhere_apiRouter
 *
 */
class Item_everywhere_apiRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_item_everywhere_api')->params;
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
			JLoader::register('Item_everywhere_apiRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('Item_everywhere_apiHelpersItem_everywhere_api', __DIR__ . '/helpers/item_everywhere_api.php');
			$this->attachRule(new Item_everywhere_apiRulesLegacy($this));
		}
	}


	

	
}
