<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('cabinet._nav',['page' => 'messages'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">User</th>
            <th scope="col">Advert</th>
            <th scope="col">Message</th>
            <th scope="col">Date</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $allDialogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dialog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="check_all_message">
            <td><?php echo e($dialog->client->name); ?></td>
            <td><a href="<?php echo e(route('adverts.show',['advert'=>$dialog->advert->id])); ?>"><?php echo e($dialog->advert->title); ?></a></td>
            <td>
                <a href="<?php echo e(route('cabinet.messages.all',['dialog'=>$dialog->id])); ?>">You have <?php echo e(Auth::id() == $dialog->user_id ? $dialog->user_new_messages: $dialog->client_new_messages); ?> missed <?php echo e(count($dialog->messages)>1 ? 'messages' : 'message'); ?></a>
            </td>
            <td><?php echo e($dialog->updated_at); ?></td>
            <td>
                <?php if($dialog->client->id === request()->user()->id): ?>
                    <a class="btn btn-danger" href="<?php echo e(route('cabinet.messages.delete',['id'=>$dialog->id])); ?>" aria-label="Delete" dusk="delete-dialog">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/message/index.blade.php ENDPATH**/ ?>