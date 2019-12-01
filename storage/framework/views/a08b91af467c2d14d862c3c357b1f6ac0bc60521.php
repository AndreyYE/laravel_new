<?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($val->id); ?>" <?php echo e(empty(!$region)?($region['id']==$val['id'] ? 'selected':''):''); ?>>
        <?php echo e($add.''.$val->name); ?>

        <?php if(isset($allRegions[$val->id])): ?>
            <?php echo $__env->make('adverts._regions',['allRegions'=>$allRegions,'region'=>$region,'regions'=>$allRegions[$val->id],'add'=>$add.'-'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /var/www/resources/views/adverts/_regions.blade.php ENDPATH**/ ?>