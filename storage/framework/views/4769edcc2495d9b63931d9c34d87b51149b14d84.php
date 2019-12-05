<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('cabinet._nav',['page'=>'promo'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <form method="get" action="<?php echo e(route('cabinet.promo.pay',['advert'=>$advert])); ?>">
        <?php echo csrf_field(); ?>
        <div class="row text-center align-items-center">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Number of clicks</label>
                    <input name="quantity" type="number" class="form-control" min="10" value="10">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cost one click (US)</label>
                    <input name="price" type="text" value="<?php echo e(env('PRICE_CLICK')); ?>" hidden>
                    <div class="border border-dark"><?php echo e(env('PRICE_CLICK')); ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total</label>
                    <input name="total" type="text" hidden >
                    <div id="total" class="border border-dark"><?php echo e(env('PRICE_CLICK')*10); ?></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    window.addEventListener('load',function(){
    $("input[name='quantity']").change(function (e) {
        let clicks = +($(this).val());
        let price = +($("input[name='price']").val());
        let total = (clicks*price).toFixed(2);
        $("input[name='total']").val(total);
        $("#total").text(total);
    })

    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/promo/create_promo.blade.php ENDPATH**/ ?>