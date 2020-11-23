<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Brandpartner
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2020 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Brandpartner controller class.
 *
 * @since  1.6
 */
class BrandpartnerControllerBrandpartner extends \Joomla\CMS\MVC\Controller\FormController
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'brandpartners';
		parent::__construct();
	}
}
