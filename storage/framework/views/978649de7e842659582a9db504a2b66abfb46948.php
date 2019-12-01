<?php $__env->startSection('breadcrumbs'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form name="form_search" method="get" data-routesearch="<?php echo e(route('adverts.my_advert',['category'=>1,'region'=>1])); ?>">
        <div class="row">
            <div class="col-md-4">
                <input id="search" name="search" type="text" class="form-control" placeholder="Search">
            </div>
            <div class="col-md-3">
                <select name="region" class="custom-select mr-sm-2 change_input" id="search_region">
                    <option value="allRegions"></option>
                    <?php $__currentLoopData = $allRegions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$regions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($reg->parent_id === null): ?>
                                <option value="<?php echo e($reg->id); ?>" class="bg-info"><?php echo e($reg->name); ?></option>
                                <?php if(isset($allRegions[$reg->id])): ?>
                                    <?php echo $__env->make('adverts._regions',['allRegions'=>$allRegions,'region'=>'','regions'=>$allRegions[$reg->id],'add'=>'-'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="custom-select mr-sm-2 change_input" id="category">
                    <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($cat->depth>0): ?>
                            <option value="<?php echo e($cat->id); ?>">
                                <?php for($i = 0; $i < $cat->depth; $i++): ?>
                                    -
                                <?php endfor; ?>
                                <div><?php echo e($cat->name); ?>










                                </div>
                            </option>
                        <?php else: ?>
                            <option value="<?php echo e($cat->id); ?>">
                                <div><?php echo e($cat->name); ?>










                                </div>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </div>
    </form>

    <?php if($categories): ?>
        <div class="card card-default mb-3 mt-5">
            <div class="card-header text-center display-4">
              All Categories
            </div>
            <div class="card-body pb-0" style="color: #aaa">
                <div class="row">
                    <?php $__currentLoopData = array_chunk($categories, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3">
                            <ul class="list-unstyled list-group">
                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item list-group-item-primary text-center">
                                        <a href="<?php echo e(route('adverts.my_advert',['category'=> $current ? $current:'allCategories', 'region'=> isset($region) ? $region :'allRegions'])); ?>" class="btn btn-outline-danger"><?php echo e($current->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<div class="row text-center">
    <div class="col-sm-12 text-capitalize display-4">
        Самые поулярные объвления
    </div>
<?php if($most_popular_adverts): ?>
    <?php $__currentLoopData = $most_popular_adverts['hits']['hits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-3 mb-3">
            <div class="card bg-secondary mx-auto text-white" style="width: 10rem;">
                <img src="<?php echo e(asset('build/'.$advert['_source']['photo'][0])); ?>" class="card-img-top" alt="НЕТ ФОТО">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(\Illuminate\Support\Str::limit($advert['_source']['title'], 20)); ?></h5>
                    <p class="card-text"><?php echo e(\Illuminate\Support\Str::limit($advert['_source']['content'],20)); ?></p>
                    <a href="<?php echo e(route('adverts.show',['advert'=>$advert['_source']['id']])); ?>" class="btn btn-primary">Показать</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
       window.addEventListener('load',function(){
          $("form[name='form_search']").submit(function(e){
              e.preventDefault();
              let route_full = $(this).data('routesearch');
              let route_length = route_full.length-3;
              let url = route_full.slice(0, route_length);
              let formData = new FormData(this);
              let region = formData.get('region');
              let category = formData.get('category');
              let search = formData.get('search');
              let href = url+category;
              if(region){
                  href = href+'/'+region;
              }
              if(search){
                  href = href+'?search='+search;
              }
              window.location.href = href;
          })
       });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/adverts/index2.blade.php ENDPATH**/ ?>