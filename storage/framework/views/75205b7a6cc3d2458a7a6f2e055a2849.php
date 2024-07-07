<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(isset($title) ? $title . ' - ' . config('app.name') : config('app.name')); ?></title>

    
    <meta name="description" content="Project Sabrina">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body>
    <?php echo e($slot); ?>

</body>

</html>
<?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>