<!doctype html>
<head>
    <title>File Handling</title>
</head>
<body>
<div align="center">
    <h3>Managing Files - Uploading and downloading files</h3><hr>
    <form action="classes/fileUpload.php" method="post" enctype="multipart/form-data">
        <label for="file">Filename: </label><input type="file" name="file" id="file"/>
        <input type="submit" name="submit" value="Submit" />
    </form>
</div>
</body>
</html>

