<html>
<head>
	<meta charset="UTF-8">
	<title>Image Upload</title>
	{!! Html::script('admin/assets/js/tinymce/plugins/imageupload/upload.js') !!}
	<script type="text/javascript">
		window.parent.window.ImageUpload.uploadSuccess({
			code : '<?= $imgSrc; ?>'
		});
	</script>
	<style type="text/css">
		img {
			max-height: 240px;
			max-width: 320px;
		}
	</style>
</head>
<body>
	<img src="<?= $imgSrc ?>">
</body>
</html>