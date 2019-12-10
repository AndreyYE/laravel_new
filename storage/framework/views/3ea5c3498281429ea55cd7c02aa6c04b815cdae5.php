<?php $__env->startSection('content'); ?>
   <form class="edit_profile" method="POST" action="<?php echo e(route('cabinet.profile.update', [$user])); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <div class="form-group">
         <label for="name" class="col-form-label">First Name</label>
         <input id="name" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
         <?php if($errors->has('name')): ?>
            <span class="invalid-feedback"><strong><?php echo e($errors->first('name')); ?></strong></span>
         <?php endif; ?>
      </div>

      <div class="form-group">
         <label for="last_name" class="col-form-label">Last Name</label>
         <input id="last_name" type="text" class="form-control<?php echo e($errors->has('last_name') ? ' is-invalid' : ''); ?>" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>" required>
         <?php if($errors->has('last_name')): ?>
            <span class="invalid-feedback"><strong><?php echo e($errors->first('last_name')); ?></strong></span>
         <?php endif; ?>
      </div>

      <div class="form-group">
         <label for="phone" class="col-form-label">Phone</label>
         <input id="phone" type="tel" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required>
         <?php if($errors->has('phone')): ?>
            <span class="invalid-feedback"><strong><?php echo e($errors->first('phone')); ?></strong></span>
         <?php endif; ?>
      </div>

      <div class="form-group">
         <button type="submit" class="btn btn-primary">Save</button>
      </div>
   </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/profile/edit.blade.php ENDPATH**/ ?>