<html>

<head>
	<title>Excel Import</title>
</head>

<body>
	<h1>Excel Import Records</h1>

	<?php if(!empty($error)): ?><p style="color:#df3826;"><?=$error;?></p> <?php endif;?>

	<div class="row">
		<form method="post" action="<?=base_url('index.php?excel_import/import_data');?>" enctype="multipart/form-data">
			<input type="file" name="file" id="fileToUpload">
			<input type="submit" value="Upload" name="submit">
		</form>
	</div>

	

</body>
</html>