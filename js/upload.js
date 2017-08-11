jQuery(document).ready(function() {
	jQuery('#ss-save').click(function(){

	alert(txt);
	
	});
	var txt= document.getElementById('name').value;
	jQuery.ajax({
type: 'POST',   // Adding Post method
url:  "<?php echo get_site_url().'/update.php'; ?>",, // Including ajax file
data: {"action": "save_name", "dname":txt}, // Sending data dname to post_word_count function.
success: function(data){ // Show returned data using the function.
alert(data);
}
});
	function save_name(){
$name = $_POST['name'];
global $wpdb;
$wpdb->insert(
	'wp_name',
	array(
		'name' => $name
	),
	
);

die();
return true;
}
});*/
