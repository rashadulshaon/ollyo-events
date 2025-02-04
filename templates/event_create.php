<?php include 'templates/header.php'; ?>

<section class="bg-body-tertiary text-center py-5">
    <h1>Create New Event</h1>
    <p class="col-lg-6 mx-auto">Please fill out the form below to create a new event.</p>
</section>

<main class="container py-5">
    <section class="col-lg-5 mx-auto">
        <form action="" method="POST" class="border border-success shadow-sm p-5">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required placeholder="Enter event title">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">summary</label>
                <textarea class="form-control" id="summary" name="summary" required placeholder="Enter event summary"></textarea>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Thumbnail URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required placeholder="Enter thumbnail URL">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" min="1" class="form-control" id="max_participants" name="max_participants" required placeholder="Enter max participants">
            </div>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Book Now</button>
        </form>
    </section>
</main>

<?php include 'templates/footer.php'; ?>