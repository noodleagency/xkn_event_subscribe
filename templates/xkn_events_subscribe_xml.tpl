<?php
?>
<!-- Inscription Mondial de l'auto 2010 -->
<event id="<?php echo $this->id_event;?>">
	<users>
<?php
for($i=0; $i<count($this->sub); $i++) {
?>
		<user id="<?php echo $this->sub[$i]['id_member'];?>">
			<type><?php echo join(', ', $this->sub[$i]['group']);?></type>
			<date><?php echo date('d/m/Y', $this->sub[$i]['date']);?></date>
			<firstname><?php echo $this->sub[$i]['firstname'];?></firstname>
			<lastname><?php echo $this->sub[$i]['lastname'];?></lastname>	
			<email><?php echo $this->sub[$i]['email'];?></email>	
			<present><?php echo $this->sub[$i]['present'];?></present>	
			<from><?php echo $this->sub[$i]['referer'];?></from>	
			<key><?php echo md5($this->sub[$i]['email'].'XXX'.$this->sub[$i]['id']);?></key>	
		</user>
<?php 
}
?>
	</users>
</event>