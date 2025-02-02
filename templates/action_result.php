<?php include 'templates/header.php'; ?>

<section class="bg-body-tertiary text-center py-5">
    <?php
    if ($actionSuccess) {
        echo '<span class="display-1 text-success d-block mb-2"><i class="ri-checkbox-circle-line"></i></span>';
        echo '<h3><span class="text-success">Congratulations!</span></h3>';
    } else {
        echo '<span class="display-1 text-danger d-block mb-2"><i class="ri-close-circle-line"></i></span>';
        echo '<h3><span class="text-danger">Error!</span></h3>';
    }
    ?>
    <p class="col-lg-6 mx-auto"><?= $actionMessage ?></span></p>
    <a href="/" class="btn btn-sm btn-primary rounded-pill px-4">Go Home <i class="ri-arrow-right-line"></i></a>
</section>

<?php include 'templates/footer.php'; ?>