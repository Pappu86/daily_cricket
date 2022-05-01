<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="url" content="<?php echo e(url('')); ?>">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>" />
    <style>
    body {
        font-family: 'Nunito', sans-serif;
    }
    </style>
</head>

<body class="antialiased">
    <div id="overlayer"></div>
    <span class="loader"></span>
    <div class="container">
        <div id="app">
            <live-upcoming></live-upcoming>
        </div>
    </div>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.js')); ?>"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>

</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/daily_cricket/resources/views/welcome.blade.php ENDPATH**/ ?>