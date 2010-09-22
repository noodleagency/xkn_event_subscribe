<?php if($this->full): ?>
<div class="blocMondial_jeuxConcours_result">

	<h1>TROP TARD !</h1>
	<p>Vous ne faites malheureusement pas partie des <?php echo $this->places; ?> heureux gagnants.</p>
	
</div>

<div class="blocBorder">
     <div class="top"></div>

     <div class="bottom">
         <h2>CEPENDANT...</h2>

          <div class="formLeft">
                        
           <p>En tant que client membre du Club SEAT, si vous comptez passer au Mondial de l'automobile, réservez dés maintenant le jour de votre passage et bénéficier d'un accès au coin VIP SEAT et d'un rafraîchissement.</p>
                    
          </div>

          <div class="formRight">
                 
        		<p><label>Sélectionnez la date de votre passage au Mondial</label>
    					<option value="0"><?php echo $this->subselect_label;?></option>
<?php
for($i=0; $i<count($this->sub_date); $i++) {
	$date = $this->sub_date[$i]['stamp'];
?>
	        					<option value="<?php echo $date;?>"><?php echo $this->sub_date[$i]['label'];?></option>
<?php
}
?>
        	     	</select>
        		</p>
        	        	
        		<input class="submit" name="" id="" type="submit" />
	
          </div>
                    
         <div class="clear"></div>
                    
      </div>

</div><!-- fin blocBorder--> 



<?php else: ?>



<div class="blocMondial_jeuxConcours_result">

	<h1>FELICITATIONS !</h1>
     <p>Vous faites partie des heureux gagnants et vous remportez<br />
     <span>un pass 2 personnes</span> pour le Salon Mondial de l'Automobile de Paris.</p>

     <p>Vous serez contacté dans les prochains jours.</p>
</div>

<div class="blocBorder">
     <div class="top"></div>

     <div class="bottom">
         <h2>Toujours plus de privilèges...</h2>

          <div class="formLeft">
                        
           	<p>sélectionnez la date de votre venue et venez profiter d'un rafraîchissement sur le stand en accédant la mezzanine SEAT !</p>
                    
          </div>

          <div class="formRight">
                 
        		<p>
            		<select name="subdate" id="subdate" style="text-align: center;">
    					<option value="0"><?php echo $this->subselect_label;?></option>
<?php
for($i=0; $i<count($this->sub_date); $i++) {
	$date = $this->sub_date[$i]['stamp'];
?>
	        					<option value="<?php echo $date;?>"><?php echo $this->sub_date[$i]['label'];?></option>
<?php
}
?>
        	     	</select>
        		</p>
        	        	
        		<input class="submit" name="" id="" type="submit" />
	
          </div>
                    
         <div class="clear"></div>
                    
     </div>

</div><!-- fin blocBorder--> 



<?php endif; ?>

<a href="<?php echo $this->back_link; ?>">retour</a>