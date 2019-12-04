<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('cabinet._nav',['page' => 'favorites'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Updated</th>
            <th>Title</th>
            <th>Region</th>
            <th>Category</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $adverts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($advert->id); ?></td>
                <td><?php echo e($advert->updated_at); ?></td>
                <td><a href="<?php echo e(route('adverts.show', $advert)); ?>" target="_blank"><?php echo e($advert->title); ?></a></td>
                <td>
                    <?php if($advert->region): ?>
                        <?php echo e($advert->region->name); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e($advert->category->name); ?></td>
                <td>
                    <form method="POST" action="<?php echo e(route('cabinet.favorites.remove', $advert)); ?>" class="mr-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger"><span class="fa fa-remove"></span> Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>

    <?php echo e($adverts->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/favorites/index.blade.php ENDPATH**/ ?>