<?php
defined('_JEXEC') or die;
?>

<div id="itemcarrello">

            <?php if(count($carrello)>0){
                echo "<div><table id='listcarrello' style='width: 50%'>
        <tr class='carr_head' style=''><td></td><td><b>Nome prodotto</b></td><td style='margin: 100px'><b>Quantità</b></td><td></td></tr>";
                foreach ($carrello as $item){
                    echo "<tr class='carr_itm' id='shopitem-".$item->id_prodotto."' style='height: 50px'>
<td><span><img class='img_carrello' src=".$item->immagine."></span></td>
<td><span class='name_carr'>".$item->name."</span></td>   
<td><span> <input class='quantity quantity_full' data-id_prod=".$item->id_prodotto." value=".$item->quantita." type='number' id='quantity' name='quantity'/></span> </td>  
<td><span class='butt_rem_carr'><img class='removebuttonfull remove button' src='images/icone/elimina.svg' aria-label=rimuovi data-id='".$item->id_prodotto."'></span></td></tr>";
                };
                echo "</div>";
            }else{
                echo "<span><b>Il tuo carrello è vuoto</b></span>";
            } ?>
    </table>
</div>
<p style="display: flex;"><input id="send" class="btn btn-primary" type="submit" value="Richiesta preventivo"/></p>
<div class="send"></div>

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

        function updateItem(id_prodotto,quantita){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=updatequantita&Itemid='+id_prodotto+'&quantita='+quantita,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        //$('#shopitem-'+id_prodotto).remove();
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

        function sendcarrello(){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=inviacarrello',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert("Richiesta di preventivo correttamente inviato");
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

        jQuery('.quantity').change(function() {
            quantita=this.value;
             id_prodotto=($(this).data('id_prod'));
             updateItem(id_prodotto,quantita);
        });

        jQuery('#send').click(function() {
            sendcarrello();
        });

    });

</script>