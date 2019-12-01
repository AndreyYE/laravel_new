<?php $__env->startSection('meta'); ?>
    <meta name="description" content="<?php echo e($page[0]->description); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="mb-3"><?php echo e($page[0]->title); ?></h1>
    <?php if($page[0]->descendants->first()): ?>
        <h3>Children of <?php echo e($page[0]->title); ?></h3>
        <ul class="list-unstyled">
            <?php $__currentLoopData = $page[0]->descendants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('page', ['id'=>$child['id']])); ?>"><?php echo e($child->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>

    <?php echo clean($page[0]->content); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/page.blade.php ENDPATH**/ ?>