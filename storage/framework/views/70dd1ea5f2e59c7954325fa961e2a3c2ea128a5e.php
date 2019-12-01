<?php $__env->startSection('content'); ?>
    <?php if($adverts): ?>
    <?php echo $__env->make('cabinet._nav',['page'=>'promo'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <table class="table text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Click</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $adverts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
                <td><a href="<?php echo e(route('adverts.show', $val)); ?>"><?php echo e($val->title); ?></a></td>
                <td><?php echo e($val->click); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($adverts->links()); ?>

        <?php else: ?>
        <h1>Вы не продвигаете ни одного объявнения</h1>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/promo/index.blade.php ENDPATH**/ ?>