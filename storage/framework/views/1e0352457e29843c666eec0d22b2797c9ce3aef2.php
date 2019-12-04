<?php $__env->startSection('content'); ?>
    <?php if($advert->isDraft()): ?>
        <div class="alert alert-danger">
            It is a draft.
        </div>
        <?php if($advert->reject_reason): ?>
            <div class="alert alert-danger">
                <?php echo e($advert->reject_reason); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($advert->isModeration()): ?>
        <div class="alert alert-danger">
            It is a moderation.
        </div>
    <?php endif; ?>

     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-adverts')): ?>
        <div class="alert-warning">Admin-Button</div>
        <div class="d-flex flex-row mb-3">

            <a href="<?php echo e(route('admin.advert.adverts.edit', $advert)); ?>" class="btn btn-primary mr-1">Edit</a>

            <a href="<?php echo e(route('admin.advert.adverts.photos', $advert)); ?>" class="btn btn-primary mr-1">Photos</a>

            <?php if($advert->isOnModeration()): ?>
                <form method="POST" action="<?php echo e(route('admin.advert.adverts.moderate', $advert)); ?>" class="mr-1">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-success">Moderate</button>
                </form>
            <?php endif; ?>

            <?php if($advert->isOnModeration() || $advert->isActive()): ?>

                <a href="<?php echo e(route('admin.advert.adverts.reject', $advert)); ?>" class="btn btn-danger mr-1">Reject</a>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.advert.adverts.destroy', $advert)); ?>" class="mr-1">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger">Delete</button>
            </form>
            <a href="<?php echo e(route('admin.advert.adverts.attributes', $advert)); ?>" class="btn btn-primary mr-1">Edit Attributes</a>
        </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-own-advert', $advert)): ?>
        <div class="alert-warning">User-Button</div>
        <div class="d-flex flex-row mb-3">

            <a href="<?php echo e(route('cabinet.adverts.edit', $advert)); ?>" class="btn btn-primary mr-1">Edit</a>
            
            <a href="<?php echo e(route('cabinet.adverts.photos', $advert)); ?>" class="btn btn-primary mr-1">Photos</a>

            <?php if($advert->isDraft()): ?>
                <form method="POST" action="<?php echo e(route('cabinet.adverts.send', $advert)); ?>" class="mr-1">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-success">Publish</button>
                </form>
            <?php endif; ?>
            <?php if($advert->isActive()): ?>
                <form method="POST" action="<?php echo e(route('cabinet.adverts.close', $advert)); ?>" class="mr-1">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-success">Close</button>
                </form>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo e(route('cabinet.adverts.destroy', $advert)); ?>" class="mr-1">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-9">

            <p class="float-right" style="font-size: 36px;"><?php echo e($advert->price); ?></p>
            <h1 style="margin-bottom: 10px"><?php echo e($advert->title); ?></h1>
            <p>
                <?php if($advert->expires_at): ?>
                    Дата публикиции: <?php echo e($advert->published_at); ?> &nbsp;
                <?php endif; ?>
                <?php if($advert->expires_at): ?>
                    Дата закрытия: <?php echo e($advert->expires_at); ?>

                <?php endif; ?>
            </p>
            <?php if(count($advert->photos)): ?>
            <div style="margin-bottom: 20px" class="border border-dark">
                <div class="row">
                    <div class="col-10">
                        <img style="height: 400px; background: red; border: 1px solid #ddd" src="<?php echo e(asset('/build/'.$advert->photos[0]->file )); ?>" class="img-fluid main-photo" alt="Responsive image">
                    </div>
                    <div class="col-2">
                        <?php $__currentLoopData = $advert->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img style="height: 100px; background: red; border: 2px solid <?php echo e($advert->photos[0]->file !== $val->file?'':'red'); ?>" src="<?php echo e(asset('/build/'.$val->file )); ?>" class="img-fluid secondary-photos" alt="Responsive image">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="bg-info text-white advert_font_size text-center">Описание</div>
            <p class="border border-dark"><?php echo nl2br(e($advert->content)); ?></p>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage-own-advert','manage-adverts'],$advert)): ?>
            <div class="row">
                <div class="col"><a class="btn btn-success mb-1" href="<?php echo e(route('cabinet.adverts.attributes',['advert'=>$advert])); ?>">Edit Attributes</a></div>
            </div>
            <?php endif; ?>
            <div class="bg-info text-white advert_font_size text-center">Характеристики</div>
            <table class="table table-bordered">
                <tbody>
                <?php $__currentLoopData = $advert->category->allAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allAttribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $allAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th><?php echo e($attribute['name']); ?></th>
                        <td><?php echo e($advert->getValue($attribute['id'])['value']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <p>Адрес: <?php echo e($advert->address); ?></p>

            <p style="margin-bottom: 20px">Продавец: <?php echo e($advert->user->name); ?></p>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('edit-own-advert', $advert)): ?>
            <div class="d-flex flex-row mb-3">
                <a class="btn btn-success mr-1" href="<?php echo e(route('adverts.form.send.message',["advert"=>$advert->id])); ?>"><span class="fa fa-envelope"></span> <span>Send Message</span></a>
                <span class="btn btn-primary phone-button mr-1" data-source="<?php echo e(route('adverts.phone', $advert)); ?>" data-setFlash="<?php echo e(route('adverts.setFlashMessage')); ?>"><span class="fa fa-phone"></span> <span class="number">Show Phone Number</span></span>
                <?php if($user && $user->hasInFavorites($advert->id)): ?>
                    <form method="POST" action="<?php echo e(route('adverts.favorites', $advert)); ?>" class="mr-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-secondary"><span class="fa fa-star"></span> Remove from Favorites</button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('adverts.favorites', $advert)); ?>" class="mr-1">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-danger"><span class="fa fa-star"></span> Add to Favorites</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <hr/>
            <?php if($similar_adverts): ?>
            <div class="bg-info text-white advert_font_size text-center">Похожие обьявления</div>
            <div class="row">
                <?php $__currentLoopData = $similar_adverts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo e(asset('/build/'.$val['_source']['photo'][0] )); ?>" alt=""/>
                        <div class="card-body">
                            <div class="card-title h4 mt-0" style="margin: 10px 0"><a href="<?php echo e(route('adverts.show',['advert'=>$val['_source']['id']])); ?>"><?php echo e(\Illuminate\Support\Str::limit($val['_source']['title'],20)); ?></a></div>
                            <p class="card-text" style="color: #666"><?php echo e(\Illuminate\Support\Str::limit($val['_source']['content'],20)); ?></p>
                            <p class="card-text" style="color: #666">Цена - <?php echo e($val['_source']['price']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php if(count($advert_adverts)): ?>
                <?php $__currentLoopData = $advert_adverts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card">
                        <img style="height: 400px; background: red; border: 1px solid #ddd" src="<?php echo e(asset('/build/'.$value['_source']['photo'][0] )); ?>" class="img-fluid clickadvert" data-routeClickAdvert="<?php echo e(route('adverts.clickAdvert',['advert'=>$value['_source']['id']])); ?>" data-showAdvert="<?php echo e(route('adverts.show',['advert'=>$value['_source']['id']])); ?>" alt="Responsive image">
                    </div>
                    <div class="card-body">
                        <div class="card-title h4 mt-0" style="margin: 10px 0"><?php echo e($value['_source']['title']); ?></div>
                        <div class="card-text h4 mt-0" style="margin: 10px 0">Цена - <?php echo e($value['_source']['price']); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>





























    <script type="text/javascript">
        /* Show phone */
        function axiosShowPhone(url, target)
        {
            axios.get(url).then((data)=>{
                //console.log(data);
                let phone = document.querySelector('.phone_show');
                if(phone){
                    phone.remove();
                }
                let button = target.querySelector('.number');
                button.innerHTML = data.data;
                target.classList.add('disabled');

            }).catch((data)=>{
                if(data.response.status == 401){
                    axios.post($(target).data('setflash'))
                    .then(response=>{
                        if(response.data ==='ok'){
                            window.location.href = window.location.origin+'/login';
                        }
                    })
                    .catch(error=>{
                        console.log(error);
                    });
                }
            });
        }

        function showPhone(evt)
        {
            if(evt.target.classList.contains('phone-button')){
                axiosShowPhone(evt.target.dataset.source, evt.target);
            }else{
                axiosShowPhone(evt.target.closest('.phone-button').dataset.source, evt.target.closest('.phone-button'));
            }
        }

        function clickAdvert(evt)
        {
         let clickTarget = $(evt.target);
         let route = clickTarget.data('routeclickadvert');
         if(!sessionStorage.getItem(route)){
             sessionStorage.setItem(route, route);
             axios.post(route)
                 .then(res=>{
                     console.log('response '+res.data);
                 })
                 .catch(error=>{
                     console.log(error);
                 })
         }
          window.location.href = clickTarget.data('showadvert')
        }

        function change_secondary_photo(evt)
        {
            $('.secondary-photos').css({"border": "2px solid"});
            $(this).css({"border": "2px solid red"});
            $('.main-photo').attr('src',$(this).attr('src'))
        }
        function ready()
        {
            let button = document.querySelector('.phone-button');
            button.addEventListener('click',showPhone, false);

            let click_advert = document.querySelector('.clickadvert');
            if(click_advert){
                click_advert.addEventListener('click',clickAdvert);
            }

            $('.secondary-photos').click(change_secondary_photo)
        }
        document.addEventListener("DOMContentLoaded", ready, false);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/adverts/show.blade.php ENDPATH**/ ?>