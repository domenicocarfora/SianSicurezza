<?php
defined('_JEXEC') or die;
?>
<div class="row">
<div class="img_partner">
    <?php
    foreach ($categorie as $categoria){
        $parametri=json_decode($categoria->params,true);
        echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4'>";
        echo "<a href='".JURI::root(). $categoria->path."'>";
        echo "<span>$categoria->name</span>";
        echo "<img class='catlogo' src='". JURI::root().$parametri['content.image']. "' alt='$categoria->name'>";
        echo "</a>";
        echo "</div>";}
    ?>

</div>
</div>
