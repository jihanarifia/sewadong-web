<?php include 'resize.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Image Upload and Resize</title>
		<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	</head>
	<body>
		<div id="page-wrapper">
			<?php if(isset($_FILES['imagetoresize'])): ?>
			<img src="<?php echo DESTINATION.$_FILES['imagetoresize']['name'] ?>" />
			<?php endif; ?>
			<?php if($error): ?>
				<p>File did not upload properly, or file is too big. 2MB maximum file size.</p>
			<?php endif; ?>
			<form action="index.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				
				<p>
					<label for="image">Select an image to upload and resize</label>
					<!--Input Field 1-->
					<input type="file" name="imagetoresize" value="" />
					<input type="hidden" name="max_file_size" value="2097152" /> 
				</p>
				
				<p>
					<!--Input Field 2-->
					<input type="submit" value="Upload &rarr;" />
				</p>
				
			</form>
		</div>
	</body>
</html>