<?php include 'templates/header.php'; ?>

<section class="bg-body-tertiary text-center py-5">
    <h1>Register to <span class="text-success"><?= $event['title'] ?>!</span></h1>
    <p class="col-lg-6 mx-auto"><?= $event['summary'] ?></p>
</section>

<main class="container py-5">
    <section class="col-lg-5 mx-auto">
        <form action="" method="POST" class="border border-success shadow-sm p-5">
            <h3>Book Now</h3>
            <p class="mb-4">Please fill out the form below to book your ticket.</p>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" min="18" class="form-control" id="age" name="age" required placeholder="Enter your age">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
            </div>
            <div class="mb-3">
                <label for="occupation" class="form-label">Occupation</label>
                <input type="text" class="form-control" id="occupation" name="occupation" required placeholder="Enter your occupation">
            </div>
            <div class="mb-3">
                <label for="shirt_size" class="form-label">Shirt Size</label>
                <select class="form-control" id="shirt_size" name="shirt_size" required>
                    <option value="" disabled selected>Select your shirt size</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required placeholder="Enter your address">
            </div>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Book Now</button>
        </form>
    </section>
</main>

<?php include 'templates/footer.php'; ?>