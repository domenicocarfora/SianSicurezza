<?php
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';


class Item_everywhere_apiControllerItems extends Item_everywhere_apiController
{

    public function &getModel($name = 'items', $prefix = 'Item_everywhere_apiModel')
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

public function getItems()
{
    $items = $this->getModel()->getItems();
    echo json_encode($items);
    exit();
}
}