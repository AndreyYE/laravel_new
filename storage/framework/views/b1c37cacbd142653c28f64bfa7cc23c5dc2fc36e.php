<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link <?php echo e($page === '' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.home')); ?>">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'profile' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.profile.index')); ?>">Profile</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'adverts' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.adverts.index')); ?>">Adverts</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'favorites' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.favorites.index')); ?>">Favorites</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'messages' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.messages.index')); ?>">Messages</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'promo' ? ' active' : ''); ?>" href="<?php echo e(route('cabinet.promo.index')); ?>">Promo</a></li>
    <li class="nav-item"><a class="nav-link <?php echo e($page === 'api' ? ' active' : ''); ?>" href="<?php echo e(url('/docs/index.html')); ?>" target="_blank">Api</a></li>
</ul>
<?php /**PATH /var/www/resources/views/cabinet/_nav.blade.php ENDPATH**/ ?>