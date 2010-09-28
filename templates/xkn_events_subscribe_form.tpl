
<div class="introMondial">

	<div  class="formMondial">

		<div class="formLeft">
			<h2>Bénéficiez d'un accès
			à la mezzanine SEAT</h2>
			<p>En tant Client membre du Club, vous aurez le privilège d'accéder à l'espace VIP SEAT lors de votre passage au Mondial 2010.
			Pour en profiter, inscrivez-vous.</p>

		</div><!-- fin left -->
		
		<div class="formRight" id="subform<?php echo $this->id;?>">
		
			<form methode="post" id="formsub<?php echo $this->id;?>" name="formsub<?php echo $this->id;?>">
				<p>Nom : <b><?php echo $this->lastname;?></b><br />
				Prénom : <b><?php echo $this->firstname;?></b></p>
<?php
if(!$this->subscribed) {
?>

				<p><label>Sélectionnez la date de votre passage au Mondial</label>
    				<select name="subdate" id="subdate" style="text-align:center;">
<!--    					<option value="0" style="text-align:center;"><?php echo $this->subselect_label;?></option> //-->
<?php
for($i=0; $i<count($this->sub_date); $i++) {
?>
	        					<option style="text-align:center;" value="<?php echo $this->sub_date[$i]['stamp'];?>"><?php echo $this->sub_date[$i]['label'];?></option>
<?php
}
?>
	        		</select></p>
	        	<input type="hidden" value="{{env::page_title}}" id="from" name="from" />	
	        	<input type="hidden" value="<?php echo $this->id;?>" id="id_event" name="id_event" />	
				<input type="submit" class="submit" name="subformbt<?php echo $this->id; ?>" id="subformbt<?php echo $this->id; ?>" />
<?php
} else {
?>
			<div>Vous êtes déjà inscrit pour le <?php echo date('d/m/Y');?></div>
<?php
}
?>
			</form>

		</div><!-- fin formRight -->

		<div class="clear"></div>

	</div><!-- fin formMondial -->

	<div class="clear"></div>

</div><!-- fin introMondial -->

     
<script type="text/javascript"> 
<!--//--><![CDATA[//><!--

addEvent('domready', function(){
	$('formsub<?php echo $this->id;?>').addEvent('submit', sendForm);
});

/**
 * enregistrement de l'inscription
 */
var sendForm = function(e) {
	e.stop(); // prevent the form from submitting
	ajaxDispatcher.refresh();
}

ajaxDispatcher.refresh = function (){
	/* Get the form values */
	var subdate = $('subdate').value;	
	var from = $('from').value;	
	jsparams = { 'from': from, 'subdate': subdate, 'event': <?php echo $this->id;?>, 'lg': '<?php echo $GLOBALS['TL_LANGUAGE'];?>'};
	ajaxDispatcher.request(this, 'subform<?php echo $this->id;?>', 'ModuleEventSubscribe', 'eventSubscribe', 'YToyOntzOjY6Im1vZF9pZCI7czoyOiI0NiI7czo0OiJsYW5nIjtzOjI6ImZyIjt9', jsparams);
	
	return true;
	
};


window.addEvent("domready", function() {
/*	var status = {
		'true': 'open',
		'false': 'close'
	};
	//-vertical
	var myVerticalSlide = new Fx.Slide('subform<?php echo $this->id;?>');
//	myVerticalSlide.hide();

	$('subformbt<?php echo $this->id; ?>').addEvent('click', function(e) {
		e.stop();
//		myVerticalSlide.toggle();
	});
	*/
});

//--><!]]>
</script> 