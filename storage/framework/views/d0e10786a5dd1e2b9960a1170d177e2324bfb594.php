<?php $__env->startSection('content'); ?>
   <div class="row">
       <div class="col-sm-12">
           <table class="table">
               <thead class="thead-light">
               <tr>
                   <th scope="col">Author</th>
                   <th scope="col">Advert</th>
                   <th scope="col">Photo</th>
               </tr>
               </thead>
               <tbody>
               <tr>
                   <td><?php echo e($dialog[0]->advert->user->name); ?></td>
                   <td>
                       <a href="<?php echo e(route('adverts.show',['advert'=>$dialog[0]->advert])); ?>"><?php echo e($dialog[0]->advert->title); ?></a>
                   </td>
                   <td>
                       <img src="<?php echo e(asset('build/'.$dialog[0]->advert->photos()->first()->file)); ?>" alt="No Photo" height="70px">
                   </td>
               </tr>
               </tbody>
           </table>
       </div>
       <div class="col-sm-12">
           <div class="overflow-auto" style="height: 25vh">
               <?php $__currentLoopData = $dialog[0]->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <div class="text-white <?php echo e($message->user->id == $dialog[0]->advert->user->id ? 'bg-dark' : 'bg-info'); ?>"><?php echo e($message->user->name); ?></div>
                   <div class="<?php echo e($message->user->id == $dialog[0]->advert->user->id ? 'text-right' : 'text-left'); ?>"><?php echo $message->message; ?></div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </div>
       </div>
       <div class="col-sm-12">
           <form id="create_message" method="POST" action="<?php echo e(route('cabinet.send.message',['dialog'=>$dialog[0]])); ?>">
               <?php echo csrf_field(); ?>

               <div class="form-group">
                   <label for="message" class="col-form-label">Message</label>
                   <textarea id="message" class="form-control<?php echo e($errors->has('message') ? ' is-invalid' : ''); ?> summernote" data-image-url="<?php echo e(route('admin.ajax.upload.image')); ?>" data-image-delete="<?php echo e(route('admin.ajax.delete.image')); ?>" name="message" rows="10" required><?php echo e(old('message')); ?></textarea>
                   <?php if($errors->has('message')): ?>
                       <span class="invalid-feedback"><strong><?php echo e($errors->first('message')); ?></strong></span>
                   <?php endif; ?>
               </div>

               <div class="form-group">
                   <button type="submit" class="btn btn-primary">Send</button>
               </div>
           </form>
       </div>
   </div>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/cabinet/message/allMessages.blade.php ENDPATH**/ ?>