<?php
defined('_JEXEC') or die;
?>

<div id="itemcarrello">

            <?php if(count($carrello)>0){
                echo "<div><table>
        <tr><td>Nome prodotto</td><td>Quantità</td><td>Opzioni</td></tr>";
                foreach ($carrello as $item){
                    echo "<tr id='shopitem-".$item->id_prodotto."'><td><span>".$item->name."</span></td>   <td><span> <input data-id_prod=".$item->id_prodotto." value=".$item->quantita." type='number' id='quantity' name='quantity'/></span> </td>  <td><span><button type=button class=remove aria-label=rimuovi data-id='".$item->id_prodotto."'> X </button></span></td></li>";
                };
                echo "</ul></div>";
            }else{
                echo "<span>Il carrello è vuoto</span>";
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
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=sendcarrello',
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

        jQuery('#quantity').change(function() {
            quantita=this.value;
             id_prodotto=($(this).data('id_prod'));
             updateItem(id_prodotto,quantita);
        });

        jQuery('#send').click(function() {
            //console.log('ciao');
            sendcarrello();
        });

    });

</script>