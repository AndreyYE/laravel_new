<?php $__env->startSection('content'); ?>
   <div class="d-flex flex-row justify-content-between align-content">
   <form method="POST" action="<?php echo e(route('cabinet.profile.phone.verify')); ?>">
      <?php echo csrf_field(); ?>


      <div class="form-group">
         <label for="token" class="col-form-label">Token</label>
         <input id="token" class="form-control<?php echo e($errors->has('token') ? ' is-invalid' : ''); ?>" name="token" value="<?php echo e(old('token', Auth::user()->phone_verity_token)); ?>" required>
         <?php if($errors->has('token')): ?>
            <span class="invalid-feedback"><strong><?php echo e($errors->first('token')); ?></strong></span>
         <?php endif; ?>
      </div>
      <div class="form-group">
         <button type="submit" class="btn btn-primary">Save</button>
      </div>
   </form>
   <form method="POST" action="<?php echo e(route('cabinet.profile.post')); ?>" class="align-self-end">
      <?php echo csrf_field(); ?>
      <div class="form-group">
         <button type="submit" class="btn btn-primary">Send message with a verify code again</button>
      </div>
   </form>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/profile/phone.blade.php ENDPATH**/ ?>