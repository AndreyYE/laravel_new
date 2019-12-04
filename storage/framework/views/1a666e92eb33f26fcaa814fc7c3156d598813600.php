<ul>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('cabinet.adverts.create.region', [$category])); ?>"><?php echo e($category->name); ?></a>
        <?php echo $__env->make('cabinet.adverts.create._categories', ['categories'=> $category->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH /var/www/resources/views/cabinet/adverts/create/_categories.blade.php ENDPATH**/ ?>