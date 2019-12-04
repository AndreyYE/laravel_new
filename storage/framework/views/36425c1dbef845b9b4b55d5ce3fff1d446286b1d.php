<?php $__env->startSection('content'); ?>

    <form id="create_message" method="POST" action="<?php echo e(route('adverts.send.message',['advert'=>$advert->id])); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="message" class="col-form-label">message</label>
            <textarea id="message" class="form-control<?php echo e($errors->has('message') ? ' is-invalid' : ''); ?> summernote" data-image-url="<?php echo e(route('admin.ajax.upload.image')); ?>" data-image-delete="<?php echo e(route('admin.ajax.delete.image')); ?>" name="message" rows="10" required><?php echo e(old('message')); ?></textarea>
            <?php if($errors->has('message')): ?>
                <span class="invalid-feedback"><strong><?php echo e($errors->first('message')); ?></strong></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        window.onload = function () {
            let form =$("#create_message");
            let url = form.data('image-delete');
            form.submit(function(e){
                let allImages = sessionStorage.getItem('allImages');
                let img = $( "#edit_page" ).find( "img" );
                let currentImages = [];
                img.each(function(index){
                    currentImages.push(this.src)
                });
                let allImage_array = allImages.split(',');
                let need_delete_images = [];
                for (let i = 0; i < allImage_array.length; i++) {
                    if(!currentImages.includes(allImage_array[i])){
                        if(allImage_array[i]){
                            need_delete_images.push(allImage_array[i]);
                        }
                    }
                }
                axios.post(url, {
                    need_delete_images
                })
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/adverts/message/create.blade.php ENDPATH**/ ?>