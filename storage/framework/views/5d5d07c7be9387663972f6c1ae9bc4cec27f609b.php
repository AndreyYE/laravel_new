<?php $__env->startSection('content'); ?>

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="?">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card mb-3">
            <div class="card-header">
                Common
            </div>
            <div class="card-body pb-2">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input id="title" class="form-control<?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>" name="title" value="<?php echo e(old('title', $advert->title)); ?>" required>
                            <?php if($errors->has('title')): ?>
                                <span class="invalid-feedback"><strong><?php echo e($errors->first('title')); ?></strong></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price" class="col-form-label">Price</label>
                            <input id="price" type="number" class="form-control<?php echo e($errors->has('price') ? ' is-invalid' : ''); ?>" name="price" value="<?php echo e(old('price', $advert->price)); ?>" required>
                            <?php if($errors->has('price')): ?>
                                <span class="invalid-feedback"><strong><?php echo e($errors->first('price')); ?></strong></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-form-label">Address</label>
                    <input id="address" type="text" class="form-control<?php echo e($errors->has('address') ? ' is-invalid' : ''); ?>" name="address" value="<?php echo e(old('address', $advert->address)); ?>" required>
                    <?php if($errors->has('address')): ?>
                        <span class="invalid-feedback"><strong><?php echo e($errors->first('address')); ?></strong></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="content" class="col-form-label">Content</label>
                    <textarea id="content" class="form-control<?php echo e($errors->has('content') ? ' is-invalid' : ''); ?>" name="content" rows="10" required><?php echo e(old('content', $advert->content)); ?></textarea>
                    <?php if($errors->has('content')): ?>
                        <span class="invalid-feedback"><strong><?php echo e($errors->first('content')); ?></strong></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/adverts/edit/advert.blade.php ENDPATH**/ ?>