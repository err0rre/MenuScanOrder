<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<!doctype html>
<html lang="en">

<body>
    <main>
        <section class="py-5 bg-light" aria-labelledby="main-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 id="main-heading" class="display-4">Create Your Menu Easily</h1>
                        <p class="lead">MenuScan simplifies the process of creating and managing your restaurant or cafe menu.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="<?= base_url('images/screenshot.jpg'); ?>" alt="Screenshot of MenuScan application interface" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5" aria-labelledby="features-heading">
            <div class="container">
                <h2 class="text-center mb-4">Key Features</h2>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card" aria-labelledby="feature-1-title">
                            <div class="card-body">
                                <h4 class="card-title">Customizable Menu Templates</h4>
                                <p class="card-text">Choose from a variety of professionally designed menu templates to suit your restaurant's style.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card" aria-labelledby="feature-2-title">
                            <div class="card-body">
                                <h4 class="card-title">Easy QR Code Generation</h4>
                                <p class="card-text">Generate QR codes for each of your menu items, making it easy for customers to access your menu online.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card" aria-labelledby="feature-3-title">
                            <div class="card-body">
                                <h4 class="card-title">Printable QR Code Stickers</h4>
                                <p class="card-text">Download printable QR code stickers to place on tables, allowing customers to scan and view your menu on their devices.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

<?= $this->endSection() ?>