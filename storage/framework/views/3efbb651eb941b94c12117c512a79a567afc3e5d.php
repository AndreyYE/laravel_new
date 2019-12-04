<?php $__env->startSection('content'); ?>

    <?php if($region): ?>
        <p>
            <a href="<?php echo e(route('cabinet.adverts.create.advert', [$category, $region])); ?>" class="btn btn-success">Add Advert for <?php echo e($region->name); ?></a>
        </p>
    <?php else: ?>
        <p>
            <a href="<?php echo e(route('cabinet.adverts.create.advert', [$category])); ?>" class="btn btn-success">Add Advert for all regions</a>
        </p>
    <?php endif; ?>

    <p>Or choose nested region:</p>

    <ul>
        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('cabinet.adverts.create.region', [$category, $current])); ?>"><?php echo e($current->name); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/adverts/create/region.blade.php ENDPATH**/ ?>