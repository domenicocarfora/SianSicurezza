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

use \Joomla\CMS\Factory;

/**
 * Class Item_everywhere_apiController
 *
 * @since  1.6
 */
class Item_everywhere_apiController extends \Joomla\CMS\MVC\Controller\BaseController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return   JController This object to support chaining.
	 *
	 * @since    1.5
     * @throws Exception
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view = Factory::getApplication()->input->getCmd('view', '//XXX_DEFAULT_VIEW_XXX');
		Factory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
