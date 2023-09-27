<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="<?php echo e(mix('/css/app.css')); ?>" rel="stylesheet" />

    <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>

    <script src="<?php echo e(mix('/js/app.js')); ?>" defer></script>
</head>
<body>
<div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div>
</body>
</html><?php /**PATH D:\OSPanel\domains\laravel-inertia-vue-crud-master\resources\views/app.blade.php ENDPATH**/ ?>