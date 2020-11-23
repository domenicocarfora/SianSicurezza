<?php
defined('_JEXEC') or die;
?>
<div class="row">
<div class="img_partner">
    <?php
    foreach ($partners as $partner){
        echo "<div class='col-xs-6 col-sm-6 col-md-3 col-lg-2 col-xl-1'>";
        if (isset($partner->link) && $partner->link!=''){
            echo "<a href='". JURI::root().$partner->link. "'>";
        }
        echo "<img class='partnerlogo' src='". JURI::root().$partner->immagine. "' alt='$partner->nome'>";
        if (isset($partner->link) || $partner->link!=''){
            echo "</a>";
        }
        echo "</div>";
    }
    ?>

</div>
</div>
