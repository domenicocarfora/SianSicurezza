<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Item_everywhere_api
 * @author     Domenico <domenico.carfora@outlook.it>
 * @copyright  2021 Domenico
 * @license    GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('Item_everywhere_apiHelper', JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_item_everywhere_api' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'item_everywhere_api.php');

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * Class Item_everywhere_apiFrontendHelper
 *
 * @since  1.6
 */
class Item_everywhere_apiHelpersItem_everywhere_api
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_item_everywhere_api/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_item_everywhere_api/models/' . strtolower($name) . '.php';
			$model = BaseDatabaseModel::getInstance($name, 'Item_everywhere_apiModel');
		}

		return $model;
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function canUserEdit($item)
    {
        $permission = false;
        $user       = Factory::getUser();

        if ($user->authorise('core.edit', 'com_item_everywhere_api'))
        {
            $permission = true;
        }
        else
        {
            if (isset($item->created_by))
            {
                if ($user->authorise('core.edit.own', 'com_item_everywhere_api') && $item->created_by == $user->id)
                {
                    $permission = true;
                }
            }
            else
            {
                $permission = true;
            }
        }

        return $permission;
    }
}
