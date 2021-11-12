<?php
	var_dump( $stage );
?>
<div class="wrap">
	<h1>Import GovPack Data</h1>
	<div class="narrow">
		<p>Howdy! Upload your WordPress eXtended RSS (WXR) file and we&#8217;ll import the posts, pages, comments, custom fields, categories, and tags into this site</p>
		<p>Choose a WXR (.xml) file to upload, then click Upload file and import</p>
		<?php wp_import_upload_form( 'admin.php?page=govpack_import' ); ?>
	</div>
</div>
