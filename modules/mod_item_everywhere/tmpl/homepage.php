<?php
defined('_JEXEC') or die;
echo "<div class='hp_items' id='hp_items'>";
foreach ($items as $item) {
    $url = JUri::base()."component/zoo/item/" . $item->alias;

    echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 item-$item->id ";
    echo "' id='hp_item-$item->id'>";
    echo "<a href='$url'> <span id='hp_item_name'><h1>$item->name</h1></span>
            <span id='hp_item_subtitle'><h3>$item->sottotitolo</h3></span>
            <div id='hp_img_item'>
            <img class='hp_prodotto_immagine' src='".JUri::base().$item->immagine."'>
            </div>
        </a>";
    echo "</div>";

}

echo "</div>";