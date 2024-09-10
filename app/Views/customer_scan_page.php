<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">


<div data-bs-spy="scroll" style="height: 100vh;" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
    <style>
        .card-group {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            flex: 1 1 calc(33.33% - 20px);
        }

        .card img {
            object-fit: cover;
            width: 100%;
            height: 200px;
        }
    </style>


<body>

    <div class="text-center">
        <!--"https://www.freepik.com/free-photo/various-food-wooden-table_3217582.htm#fromView=search&page=1&position=52&uuid=99e6b57f-3714-4eee-b02e-a09c9373cfbd" Image by freepik-->
        <img src="<?= base_url('images/meat.jpg'); ?>" class="rounded d-block mx-auto" style="width: 95%; height: auto; max-height: 100px; object-fit: cover;"  alt="Header Image">
    </div>
        <div class="p-2 text-center">
            <a class="navbar-brand rounded p-2" style="background-color: #ffffff; font-size: 30px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;" href="#"> <?= esc($restaurant_name) ?>'s full menu</a>
        </div>
        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
    <ul class="nav nav-pills">
        <?php foreach ($categories as $category => $items) : ?>
            <li class="nav-item">
                <a class="nav-link" href="#scrollspyHeading<?= strtolower($category) ?>"><?= $category ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<div class="scrollspy-content">
    <?php foreach ($categories as $category => $items) : ?>
        <!-- Display the category heading with an ID for scrollspy navigation -->
        <h4 id="scrollspyHeading<?= strtolower($category) ?>"><?= $category ?></h4>
        <div class="card-group p-3">
            <?php foreach ($items as $item) : ?>
                <div class="card" style="padding: 10px;">
                    <?php
                    // Get the BLOB data of the item's image
                    $image_data = $item['image'];
                    // Convert the BLOB data to a base64-encoded string
                    $image_base64 = base64_encode($image_data);
                    ?>
                    <!-- Display the image using the base64-encoded string -->
                    <img src="data:image/jpeg;base64,<?= $image_base64 ?>" class="card-img-top rounded" alt="<?= esc($item['name']) ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <!-- Display the item name with a category-specific class -->
                                <h5 class="<?= esc($item['category']) ?>"><?= esc($item['name']) ?></h5>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <!-- Add to cart button with a data attribute for the item ID -->
                                <button type="button" class="btn btn-outline-warning add-to-cart" data-id="<?= esc($item['id']) ?>">Add</button>
                            </div>
                        </div>
                        <p class="card-text"><?= esc($item['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
</div>

<!-- Display alert if there's a flash message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<?php foreach ($tables as $table) : ?>
    <?php
    $last_table_id = $table['id'];
    ?>
<?php endforeach; ?>

<div class="container mt-3">
    <!-- Button to add an order, styled with Bootstrap classes -->
    <div class="d-flex justify-content-center mb-4">
        <button type="button" class="btn btn-primary position-relative cart-button w-75" id="addOrderBtn">
            <!-- Form to store order details, hidden inputs to hold order data -->
            <form id="orderForm" style="display: none;">
                <?= csrf_field() ?>
                <input type="hidden" id="orderId" name="order_id">
                <input type="hidden" id="tableId" name="table_id" value="<?php echo $last_table_id; ?>">
                <input type="hidden" id="status" name="status" value="pending">
                <input type="hidden" id="createdAt" name="created_at" value="<?= date('Y-m-d') ?>"> 
                <input type="hidden" id="dishes" name="dishes" value="">
            </form>
            <!-- SVG icon for the cart button -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            Cart
            <!-- Badge to show the number of items in the cart -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">0</span>
        </button>
    </div>
    <!-- Alert box to show order-related messages -->
    <div id="orderAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
        <span id="orderAlertMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
</body>

<script>
    // Select cart button and badge
    const cartButton = document.querySelector('.cart-button');
    const cartBadge = cartButton.querySelector('.cart-badge');
    let cartCount = 0;
    // Add event listeners to all "Add to Cart" buttons
    const addButtons = document.querySelectorAll('.add-to-cart');
    addButtons.forEach(button => {
        button.addEventListener('click', () => {
            cartCount++;
            cartBadge.textContent = cartCount;
        });
    });

    // Function to show the alert message
    function showAlert(message, type) {
        const alertBox = document.getElementById('orderAlert');
        const alertMessage = document.getElementById('orderAlertMessage');
        alertMessage.textContent = message;
        alertBox.classList.remove('alert-success', 'alert-danger');
        alertBox.classList.add(`alert-${type}`);
        alertBox.style.display = 'block';

        // Hide the alert after 10 seconds
        setTimeout(function() {
        alertBox.style.display = 'none';
        }, 5000);
    }

    let addedItems = [];

    // Add event listeners to "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            // Get the item name from the card
            const itemName = button.closest('.card').querySelector('h5').textContent;
            // Add the item name to the array
            addedItems.push(itemName);

            // Log the list of added items to the console
            console.log('Added items:', addedItems.join(', '));
        });
    });

    // Add Menu Button Click
    document.getElementById('addOrderBtn').addEventListener('click', function() {
        const form = document.getElementById('orderForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Convert the array to a comma-separated string
        const dishesString = addedItems.join(',');
        data.dishes = dishesString;

        // Add new order
        fetch('<?= base_url("order"); ?>', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
            // order added successfully
            showAlert('Order added successfully.', 'success');
            } else {
            // Error occurred
            showAlert('Error adding order. Please try again.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error adding order. Please try again.', 'danger');
        });
        }
    );
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>

<!--"https://www.freepik.com/free-photo/closeup-shot-gourmet-fried-tofu-sandwich-plate_28741874.htm#query=dish&position=4&from_view=author&uuid=54f11c45-5a18-43e9-a907-5fd1c05c85a3" Image by wirestock on Freepik-->
<!--"https://www.freepik.com/free-photo/vegetable-salad-plate_7678642.htm#query=dish&position=2&from_view=author&uuid=54f11c45-5a18-43e9-a907-5fd1c05c85a3" Image by wirestock on Freepik-->
<!--"https://www.freepik.com/free-photo/stack-pancakes-with-dripping-maple-syrup-glass-fresh-orange-juice_30467443.htm#query=dishes&position=39&from_view=author&uuid=0ad02666-869c-4f3b-a870-3255c4296b30" Image by wirestock on Freepik-->
<!--"https://www.freepik.com/free-photo/dinner-noodle-chicken-cuisine-food_1043513.htm#fromView=search&page=1&position=3&uuid=1b68ab3a-3aa1-4bba-bfab-0441b0c3464d" Image by mrsiraphol on Freepik-->
<?= $this->endSection() ?>