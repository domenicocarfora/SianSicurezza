<?php
defined('_JEXEC') or die;
?>
<div class="carrello"><p><a class="btn" data-target="#itemcarrello" role="button" data-toggle="modal" data-backdrop="static" data-keyboard="false">
            <?php if(count($carrello)>0){
                echo "<span class='contcarrello'>".count($carrello)."</span>";
            } ?>
<img class='imgcarrello' src='/images/icone/carrello.png' alt='Visualizza carrello'>
        </a></p>
</div>

<div id="itemcarrello" class="modal fade in" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-content">
        <div class="modal-body">
            <?php if(count($carrello)>0){
                echo "<div><ul>";
                foreach ($carrello as $item){
                    echo "<li id='shopitem-".$item->id_prodotto."'><span>".$item->name."</span>   <span>  x".$item->quantita."</span> <span><img class='removebutton button remove' aria-label='rimuovi' src='/images/icone/elimina.svg' data-id='".$item->id_prodotto."'></span></li>";
                };
                echo "</ul></div>";
                echo "<div><a href='/carrello'> Vai al Carrello</a></div>";
            }else{
                echo "<span>Il carrello è vuoto</span>";
            } ?>
        </div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {


        function removeItem(id_prodotto){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=removeItem&Itemid='+id_prodotto,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log($('#shopitem-'+id_prodotto));
                    if (data.success) {
                        $('#shopitem-'+id_prodotto).remove();
                    }else{
                        console.log(data);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }
        jQuery('.remove').click(function() {
                id_prodotto=($(this).data('id'));
                removeItem(id_prodotto);
        });

    });

</script>