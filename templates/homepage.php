<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.css">
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Ollyo Events</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor04" aria-controls="navbarColor04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor04">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </header>

    <section class="bg-body-tertiary text-center py-5">
        <h1>Howdy, Welcome to Ollyo Events!</h1>
        <p class="col-lg-6 mx-auto">Explore our list of events, which are carefully curated to ensure that you find exactly what you're looking for. Whether you're interested in concerts, festivals, conferences, or workshops, we've got you covered.</p>
    </section>

    <main class="container py-5">
        <h3 class="text-center mb-5">Our Latest Events</h3>
        <div class="row">
            <?php foreach ($data as $event): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <img src="<?= $event['image_url']; ?>" class="card-img-top" alt="...">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($event['summary']); ?></p>
                            <a href="book/<?= htmlspecialchars($event['id']); ?>" class="btn btn-sm btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="text-center">
        <p>Developed by <a target="_blank" href="https://shaon.pages.dev">Rashadul Shaon</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>