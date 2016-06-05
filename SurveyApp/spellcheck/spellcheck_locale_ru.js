	<script type="text/javascript" src="speller/spell.js"></script>
	<script type="text/javascript">
	var speller = new Speller({ url:"speller", lang:"en", options:Speller.IGNORE_URLS });
	 
	function spellCheck() {
		var form = document.forms["myform"];
		speller.check([ form.ctrl_1, form.ctrl_2, ..., form.ctrl_N ]);
	}
	</script>