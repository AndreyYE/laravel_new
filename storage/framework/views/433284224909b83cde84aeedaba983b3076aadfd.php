<?php $__env->startSection('content'); ?>
    <form method="POST" action="?">
        <?php echo csrf_field(); ?>

        <?php $__currentLoopData = $advert->category->allAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-group">
                    <label for=attribute_<?php echo e($attribute['id']); ?>" class="col-form-label"><?php echo e($attribute['name']); ?></label>

                    <?php if($errors->has('attributes.' . $attribute['id'])): ?>
                        <?php $__currentLoopData = $errors->get('attributes.' . $attribute['id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="alert alert-danger">
                                <?php echo e($val); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if(\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isSelect()): ?>
                        <select id="attribute_<?php echo e($attribute['id']); ?>" class="form-control<?php echo e($errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : ''); ?>" name="attributes[<?php echo e($attribute['id']); ?>]">
                            <option value=""></option>
                            <?php $__currentLoopData = \App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($variant); ?>" <?php echo e(\App\Entity\Adverts\Advert\Value::where('attribute_id',$attribute['id'])->where('advert_id',$advert->id)->first()['value'] == $variant ? 'selected':''); ?> <?php echo e($variant==old('attributes.'.$attribute['id']) ? 'selected':''); ?>>
                                    <?php echo e($variant); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                    <?php elseif(\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isNumber()): ?>

                        <input id="attribute_<?php echo e($attribute['id']); ?>" type="number" class="form-control <?php echo e($errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : ''); ?>" name="attributes[<?php echo e($attribute['id']); ?>]" value="<?php echo e(old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value'])); ?>">

                    <?php elseif(\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->isSlider()): ?>

                        <input id="attribute_<?php echo e($attribute['id']); ?>" type="text" class="js-range-slider <?php echo e($errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : ''); ?>" name="attributes[<?php echo e($attribute['id']); ?>]" value=""
                               data-min="<?php echo e(\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants[0]); ?>"
                               data-max="<?php echo e(\App\Entity\Adverts\Attribute::findOrFail($attribute['id'])->variants[1]); ?>"
                               data-from="<?php echo e(old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value'])); ?>"
                               data-grid="true"
                        />

                    <?php else: ?>
                        <input id="attribute_<?php echo e($attribute['id']); ?>" type="text" class="form-control<?php echo e($errors->has('attributes.' . $attribute['id']) ? ' is-invalid' : ''); ?>" name="attributes[<?php echo e($attribute['id']); ?>]" value="<?php echo e(old('attributes.' . $attribute['id'], $advert->getValue($attribute['id'])['value'])); ?>">

                    <?php endif; ?>

                    <?php if($errors->has('parent')): ?>
                        <span class="invalid-feedback"><strong><?php echo e($errors->first('attributes.' . $attribute['id'])); ?></strong></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        window.addEventListener('load',function(){
            $(".js-range-slider").ionRangeSlider();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/adverts/edit/attributes.blade.php ENDPATH**/ ?>