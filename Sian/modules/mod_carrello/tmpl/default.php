<?php
defined('_JEXEC') or die;
?>
<div class="carrello"><p><a class="btn" href="#itemcarrello" role="button" data-toggle="modal">
            <?php if(count($carrello)>0){
                echo "<span class='contcarrello'>".count($carrello)."</span>";
            } ?>
<img class='imgcarrello' src='/images/icone/carrello.png' alt='Visualizza carrello'>
        </a></p>
</div>

<div id="itemcarrello" class="panel" style="display: none;">
    <div class="modal-content">
        <div class="modal-body">
            <?php if(count($carrello)>0){
                echo "<div><ul>";
                foreach ($carrello as $item){
                    echo "<li id='shopitem-".$item->id_prodotto."'><span>".$item->name."</span>   <span>  x".$item->quantita."</span>   <span><button type=button class=remove aria-label=rimuovi data-id='".$item->id_prodotto."'> X </button></span></li>";
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