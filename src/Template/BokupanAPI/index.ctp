<?= $this->Html->script('jquery-2.0.3.min.js') ?>
<?= $this->Html->script('bokupan-api.js') ?>

<script>
	BokupanAPI.addRoom({
		"name"      : "僕パンやろうぜ！",
		"host_user" : "makimaki-soft",
		"message"   : "初心者歓迎",
	}, function(data){
		console.log(data);
	}, function(){
		console.log("fail");
	});
</script>