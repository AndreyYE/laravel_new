<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('cabinet._nav',['page' => 'profile'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-3">
        <a href="<?php echo e(route('cabinet.profile.edit',$user)); ?>" class="btn btn-primary">Edit</a>
    </div>

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>First Name</th><td><?php echo e($user->name); ?></td>
        </tr>
        <tr>
            <th>Last Name</th><td><?php echo e($user->last_name); ?></td>
        </tr>
        <tr>
            <th>Email</th><td><?php echo e($user->email); ?></td>
        </tr>
        <tr>
            <th>Phone</th><td>
                <?php if($user->phone): ?>
                    <div class="d-flex flex-row justify-content-between">
                    <?php echo e($user->phone); ?>

                    <?php if(!$user->isPhoneVerified()): ?>
                        <i>(is not verified)</i><br />
                        <form method="POST" action="<?php echo e(route('cabinet.profile.post')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-success">Verify</button>
                        </form>
                    <?php endif; ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <?php if($user->phone): ?>
            <tr>
                <th>Two Factor Auth</th><td>
                    <form method="POST" action="<?php echo e(route('cabinet.profile.phone.auth')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if($user->isPhoneAuthEnabled()): ?>
                            <button type="submit" class="btn btn-sm btn-success">On</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-sm btn-danger">Off</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/profile/home.blade.php ENDPATH**/ ?>