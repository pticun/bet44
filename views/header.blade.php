<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $browser_title;?></title>

    {{--<?php foreach ($js_files as $js_file): ?>--}}
        {{--<script src="<?php echo $js_file;?>"></script>--}}
    {{--<?php endforeach; ?>--}}

    <?php foreach ($css_files as $css_file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $css_file;?>">
    <?php endforeach; ?>
</head>
<body>

