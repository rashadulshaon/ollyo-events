<?php include 'templates/header.php'; ?>

<section class="bg-body-tertiary text-center py-5">
    <h1>Howdy, Welcome to <span class="text-success">Ollyo Events!</span></h1>
    <p class="col-lg-6 mx-auto">Explore our list of events, which are carefully curated to ensure that you find exactly what you're looking for. Whether you're interested in concerts, festivals, conferences, or workshops, we've got you covered.</p>
</section>

<main class="container py-5">
    <h3 class="text-center mb-5">Our Latest Events</h3>
    <div class="row">
        <?php foreach ($data as $event): ?>
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card shadow-sm border-success p-1">
                    <img src="<?= $event['image_url']; ?>" class="card-img-top rounded-3 p-3" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($event['summary']); ?></p>
                        <a href="book/<?= htmlspecialchars($event['id']); ?>" class="btn btn-sm btn-primary rounded-pill px-4">Book Now <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'templates/footer.php'; ?>