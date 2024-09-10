<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<script src="<?= base_url('lib/qrcode.min.js'); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!--User and restaurants -->
<div class="container">
    <!-- User -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title" id="user-info-heading">User Information</h2>
                </div>
                <div class="card-body">
                    <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
                    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>  
                </div>
            </div>
        </div>
        
        <!-- restaurants -->
        <div class="col-md-6 mb-4">
          <div class="card mb-4">
            <div class="card-header">
              <h2 class="card-title" id="restaurant-details-heading">Restaurant Details</h2>
            </div>
            <div class="card-body" id="restaurantCardBody">
              <?php if (empty($restaurant)) : ?>
                  <div>No restaurant found.</div>
              <?php else : ?>
                  <p><strong>Name:</strong> <?= esc($restaurant['name']) ?></p>
                  <p><strong>Address:</strong> <?= esc($restaurant['address']) ?></p>
                  <p><strong>Phone Number:</strong> <?= esc($restaurant['phone_number']) ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </div>
  </div>

<!-- Menus and tables -->
<div class="container">
    <div class="row" style="padding-bottom: 25px;">
      <!-- Menus -->
      <div class="col-md-8 mb-3 mb-md-0">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title" id="menu-heading">Menus</h2>
            </div>
            <div class="card-body">
                <table class="table" aria-labelledby="menu-heading">
                    <thead>
                        <tr>
                            <th scope="col">Menu ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Website</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="menuTableBody">
                    <?php if (empty($menus)) : ?>
                      <!-- Display message if no menus are found -->
                      <tr>
                          <td colspan="6">No menu found.</td>
                      </tr>
                    <?php else : ?>
                        <!-- Loop through menus and display each one -->
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td><?= esc($menu['id']) ?></td>
                                <td><?= esc($menu['menu_name']) ?></td>
                                <td><a href="<?= base_url('menu/'.$menu['id']);?>">View Menu</a> </td>
                                <td>
                                    <input type="hidden" class="menu-id" value="<?= esc($menu['id']) ?>">
                                    <input type="hidden" class="restaurant-id" value="<?= esc($menu['restaurant_id']) ?>">
                                    <button type="button" class="btn btn-primary btn-sm edit-menu" data-bs-toggle="modal" data-bs-target="#menuModal" aria-label="Edit Menu <?= esc($menu['menu_name']) ?>">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm delete-menu" aria-label="Delete Menu <?= esc($menu['menu_name']) ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#menuModal" id="addMenuBtn" aria-label="Add Menu">Add Menu</button>
                <div id="menuAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
                    <span id="menuAlertMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
      </div> 

      <!-- Tables -->
      <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title" id="table-heading">Tables</h2>
            </div>
            <div class="card-body">
              <table class="table" aria-labelledby="table-heading">
                  <thead>
                      <tr>
                          <th scope="col">Table Number</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if (empty($tables)) : ?>
                          <tr>
                              <td>No table found.</td>
                          </tr>
                      <?php else : ?>
                          <tr>
                              <td><?= esc($tablesCount) ?></td>
                          </tr>
                          <body>
                          <?php if (empty($menu)) : ?>
                            <tr>
                              <td>No menu found.</td>
                          </tr>
                      <?php else : ?>
                        <!-- QR code button -->
                        <button type="button" class="btn btn-primary mb-3" id="generateQR" aria-label="Generate QR Code">Generate QR Code</button>

                        <script>
                            document.getElementById('generateQR').addEventListener('click', function() {
                                // open a new window
                                var newWindow = window.open();
                                <?php foreach ($tables as $table): ?>
                                    // create container for QR code and table ID
                                    var container<?= $table['id']; ?> = newWindow.document.createElement('div');
                                    newWindow.document.body.appendChild(container<?= $table['id']; ?>);

                                    
                                      // create QR code
                                      var qrData<?= $table['id']; ?> = '<?= base_url('menu/' . $menu['id']); ?>';
                                      new QRCode(container<?= $table['id']; ?>, qrData<?= $table['id']; ?>);
                                    

                                    // display table ID
                                    var tableId<?= $table['id']; ?> = newWindow.document.createElement('p');
                                    tableId<?= $table['id']; ?>.textContent = 'Table ID: <?= $table['id']; ?>';
                                    container<?= $table['id']; ?>.appendChild(tableId<?= $table['id']; ?>);

                                    // add some styling
                                    container<?= $table['id']; ?>.style.marginBottom = '20px';
                                    container<?= $table['id']; ?>.style.textAlign = 'left';
                                <?php endforeach; ?>

                                // download link
                                var downloadBtn = newWindow.document.createElement('button');
                                downloadBtn.textContent = 'Download QR Codes';
                                downloadBtn.addEventListener('click', function() {
                                    // get QR code images
                                    var qrImages = newWindow.document.querySelectorAll('img');
                                    qrImages.forEach(function(image, index) {
                                        var link = newWindow.document.createElement('a');
                                        link.href = image.src;
                                        link.download = 'QR_Code_' + index + '.png'; // file name
                                        newWindow.document.body.appendChild(link);
                                        link.click();
                                    });
                                });
                                newWindow.document.body.appendChild(downloadBtn);
                            });
                        </script>
                        <?php endif; ?>
                      </body>
                      <?php endif; ?>
                  </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>

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

<!-- Items -->
<section class="py-5">
  <div class="container">
      <section>
          <div class="container">
              <div class="row">
              <?php if (empty($menus)) : ?>
                <div class="row">
                <h2>Items</h2>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th colspan="6">Please create a menu to continue.</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              <?php else : ?>       
                <?php foreach ($menus as $menu) : ?>
                  <div id="menu<?= esc($menu['id']) ?>">
                  <h2>Items for <?= esc($menu['menu_name']) ?></h2>
                  <div class="table-responsive">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Category</th>
                              <th>Price</th>
                              <th>Description</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody id="itemTableBody">
                      <?php if (empty($items[$menu['id']])) : ?>
                          <tr>
                              <td colspan="6">No items found for this menu.</td>
                          </tr>
                      <?php else : ?>
                        <?php foreach ($items[$menu['id']] as $item) : ?>
                            <tr>
                                <td><?= esc($item['id']) ?></td>
                                <td><?= esc($item['name']) ?></td>
                                <td><?= esc($item['category']) ?></td>
                                <td><?= esc($item['price']) ?></td>
                                <td><?= esc($item['description']) ?></td>
                                <td>
                                    <input type="hidden" class="item-id" value="<?= esc($item['id']) ?>">
                                    <input type="hidden" class="menu-id" value="<?= esc($item['menu_id']) ?>">
                                    <button type="button" class="btn btn-primary btn-sm edit-item" data-bs-toggle="modal" data-bs-target="#itemModal" aria-label="Edit Item">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm delete-item" aria-label="Delete Item">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      </tbody>
                    </table>
                    </div>
                    <button type="button" class="btn btn-primary mb-3 add-item-btn" data-bs-toggle="modal" data-bs-target="#itemModal" data-menu-id="<?= esc($menu['id']) ?>">Add item</button>
                  <div id="itemAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
                      <span id="itemAlertMessage"></span>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
      </section>
  </div>
  </section>

<!-- Orders -->
<section>
    <div class="container">
        <div class="row">
            <h2>Order</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Table id</th>
                        <th>Status</th>
                        <th>Dishes</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <?php if (empty($orders)) : ?>
                        <tr>
                            <td colspan="5">No order found.</td>
                        </tr>
                    <?php else : ?>
                      <?php foreach ($tables as $table) : ?>
                        <?php if (!empty($orders[$table['id']])) : ?>
                          <?php foreach ($orders[$table['id']] as $order) : ?>
                            <tr>
                                <td><?= esc($order['id']) ?></td>
                                <td><?= esc($order['table_id']) ?></td>
                                <td><?= esc($order['status']) ?></td>
                                <td><?= esc($order['dishes']) ?></td>
                                <td><?= esc($order['created_at']) ?></td>
                                <td>
                                    <input type="hidden" class="order-id" value="<?= esc($order['id']) ?>">
                                    <input type="hidden" class="table-id" value="<?= esc($order['table_id']) ?>">
                                    <button type="button" class="btn btn-primary btn-sm edit-order" data-bs-toggle="modal" data-bs-target="#orderModal" aria-label="Edit Order">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm delete-order" aria-label="Delete Order">Delete</button>
                                </td>
                            </tr>
                          <?php endforeach; ?>                      
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
  </section>

<?php if (!empty($restaurant)) : ?>
  <section class="menu">
      <!-- Menu Modal -->
      <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="menuModalLabel">Add Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="menuForm">
                
                <div class="mb-3">
                  <label for="menu_name" class="form-label">name</label>
                  <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                </div>
                <input type="hidden" id="menuId" name="menu_id">
                <input type="hidden" id="restaurantId" name="restaurant_id" value="<?= esc($restaurant['id']) ?>">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
              <button type="button" class="btn btn-primary" id="saveMenu" aria-label="Save Menu">Save</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Template for new menu row -->
      <template id="menuRowTemplate">
        <tr>
          <td class="menu_name"></td>
          <td>
            <input type="hidden" class="menu-id" value="">
            <input type="hidden" class="restaurant-id" value="">
            <button type="button" class="btn btn-primary btn-sm edit-menu" data-bs-toggle="modal" data-bs-target="#menuModal" aria-label="Edit Menu">Edit</button>
            <button type="button" class="btn btn-danger btn-sm delete-menu" aria-label="Delete Menu">Delete</button>
          </td>
        </tr>
      </template>

      <script>
        // Function to show the alert message
        function showAlert(message, type) {
          const alertBox = document.getElementById('menuAlert');
          const alertMessage = document.getElementById('menuAlertMessage');
          alertMessage.textContent = message;
          alertBox.classList.remove('alert-success', 'alert-danger');
          alertBox.classList.add(`alert-${type}`);
          alertBox.style.display = 'block';

          // Hide the alert after 10 seconds
          setTimeout(function() {
            alertBox.style.display = 'none';
          }, 5000);
        }

        // Add Menu Button Click
        document.getElementById('addMenuBtn').addEventListener('click', function() {
          document.getElementById('menuModalLabel').textContent = 'Add Menu';
          document.getElementById('menuForm').reset();
          document.getElementById('menuId').value = '';
        });

        // Edit Menu Button Click
        document.addEventListener('click', function(event) {
          if (event.target.classList.contains('edit-menu')) {
            // Get menu and restaurant IDs
            const menuId = event.target.closest('tr').querySelector('.menu-id').value;
            const restaurantId = event.target.closest('tr').querySelector('.restaurant-id').value;
            const menu_name = event.target.closest('tr').cells[1].textContent;

            document.getElementById('menuModalLabel').textContent = 'Edit Menu';
            document.getElementById('menu_name').value = menu_name;
            document.getElementById('menuId').value = menuId;
            document.getElementById('restaurantId').value = restaurantId;
          }
        });

        document.getElementById('saveMenu').addEventListener('click', function() {
          const form = document.getElementById('menuForm');
          const formData = new FormData(form);
          const menuId = formData.get('menu_id');
          const data = Object.fromEntries(formData.entries());

          if (menuId) {
            // Update existing menu
            fetch(`<?= base_url("menu"); ?>/${menuId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
              if (data) {
                // Menu updated successfully
                const row = document.querySelector(`.menu-id[value="${menuId}"]`).closest('tr');
                row.cells[1].textContent = formData.get('menu_name');
                bootstrap.Modal.getInstance(document.getElementById('menuModal')).hide();
                showAlert('Menu updated successfully.', 'success');
              } else {
                // Error occurred
                showAlert('Error updating menu. Please try again.', 'danger');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showAlert('Error updating menu. Please try again.', 'danger');
            });
          } else {
            // Add new menu
            fetch('<?= base_url("menu"); ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
              if (data) {
                // Menu added successfully
                const template = document.getElementById('menuRowTemplate');
                const newRow = template.content.cloneNode(true);
                newRow.querySelector('.menu-id').value = data.menu_id;
                newRow.querySelector('.restaurant-id').value = formData.get('restaurant_id');
                newRow.querySelector('.menu_name').textContent = formData.get('menu_name');

                document.getElementById('menuTableBody').appendChild(newRow);
                form.reset();
                bootstrap.Modal.getInstance(document.getElementById('menuModal')).hide();
                showAlert('Menu added successfully.', 'success');
              } else {
                // Error occurred
                showAlert('Error adding menu. Please try again.', 'danger');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showAlert('Error adding menu. Please try again.', 'danger');
            });
          }
        });

        // Delete Menu Button Click
        document.addEventListener('click', function(event) {
          if (event.target.classList.contains('delete-menu')) {
            const menuId = event.target.closest('tr').querySelector('.menu-id').value;
            const confirmation = confirm('Are you sure you want to delete this menu?');

            if (confirmation) {
              fetch(`<?= base_url("menu"); ?>/${menuId}`, {
                method: 'DELETE'
              })
              .then(response => response.json())
              .then(data => {
                if (data) {
                  // Menu deleted successfully
                  event.target.closest('tr').remove();
                  showAlert('Menu deleted successfully.', 'success');
                } else {
                  // Error occurred
                  console.error('Error deleting menu:', data.error);
                  showAlert('Error deleting menu. Please try again.', 'danger');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                showAlert('Error deleting menu. Please try again.', 'danger');
              });
            }
          }
        });
      </script>
  </section>
  <?php endif; ?>

  
<?php if (!empty($menu)) : ?>
  <section class="item">
    <!-- Item Modal -->
    <section class="item">
      <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="itemModalLabel">Add Item</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="itemForm">
                
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                  <label for="category" class="form-label">Category</label>
                  <input type="text" class="form-control" id="category" name="category" required>
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <input type="hidden" id="itemId" name="item_id">
                <input type="hidden" id="menuId" name="menu_id" value="">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
              <button type="button" class="btn btn-primary" id="saveItem" aria-label="Save Item">Save</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Template for new item row -->
      <template id="itemRowTemplate">
        <tr>
          <td class="name"></td>
          <td class="category"></td>
          <td class="description"></td>
          <td class="price"></td>
          <td>
            <input type="hidden" class="item-id" value="">
            <input type="hidden" class="menu-id" value="">
            <button type="button" class="btn btn-primary btn-sm edit-item" data-bs-toggle="modal" data-bs-target="#itemModal" aria-label="Edit Menu">Edit</button>
            <button type="button" class="btn btn-danger btn-sm delete-item" aria-label="Delete Menu">Delete</button>
          </td>
        </tr>
      </template>

      <script>
        // Function to show the alert message
        function showAlert(message, type) {
          const alertBox = document.getElementById('itemAlert');
          const alertMessage = document.getElementById('itemAlertMessage');
          alertMessage.textContent = message;
          alertBox.classList.remove('alert-success', 'alert-danger');
          alertBox.classList.add(`alert-${type}`);
          alertBox.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
        // Add Item Button Click
        document.querySelectorAll('.add-item-btn').forEach(button => {
          button.addEventListener('click', function() {
            document.getElementById('itemForm').reset(); // Reset form
            const menuId = this.getAttribute('data-menu-id'); // Get menu ID from button attribute
            document.getElementById('menuId').value = menuId; // Set menu ID in hidden input
            document.getElementById('itemModalLabel').textContent = 'Add Item';
            document.getElementById('itemId').value = '';
          });
        });
        // Edit item Button Click
        document.addEventListener('click', function(event) {
          if (event.target.classList.contains('edit-item')) {
            const containerId = event.target.closest('div[id^="menu"]').id;
            const menuId = containerId.replace('menu', ''); // Extract menu ID from container ID
            const itemId = event.target.closest('tr').querySelector('.item-id').value;
            const name = event.target.closest('tr').cells[1].textContent;
            const category = event.target.closest('tr').cells[2].textContent;
            const description = event.target.closest('tr').cells[4].textContent;
            const price = event.target.closest('tr').cells[3].textContent;
            
            document.getElementById('itemModalLabel').textContent = 'Edit Item';
            document.getElementById('name').value = name;
            document.getElementById('category').value = category;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('itemId').value = itemId;
            document.getElementById('menuId').value = menuId;
          }
        });

        // Save Item Button Click
        document.getElementById('saveItem').addEventListener('click', function() {
          const form = document.getElementById('itemForm');
          const formData = new FormData(form);
          const itemId = formData.get('item_id');
          const menuId = document.getElementById('menuId').value; // Get menu ID from form

          formData.set('menu_id', menuId);// Manually add menu_id to FormData

          const data = Object.fromEntries(formData.entries());// Convert FormData to object

          if (itemId) {
            // Update existing item
            fetch(`<?= base_url("item"); ?>/${itemId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
              if (data) {
                // item updated successfully
                const row = document.querySelector(`.item-id[value="${itemId}"]`).closest('tr');
                row.cells[1].textContent = formData.get('name');
                row.cells[2].textContent = formData.get('category');
                row.cells[4].textContent = formData.get('description');
                row.cells[3].textContent = formData.get('price');;
                bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
                showAlert('Item updated successfully.', 'success');
              } else {
                // Error occurred
                showAlert('Error updating item. Please try again.', 'danger');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showAlert('Error updating item. Please try again.', 'danger');
            });
          } else {
            // Add new item
            fetch('<?= base_url("item"); ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
              if (data) {
                // item added successfully
                const template = document.getElementById('itemRowTemplate');
                const newRow = template.content.cloneNode(true);
                newRow.querySelector('.item-id').value = data.item_id;
                newRow.querySelector('.menu-id').value = formData.get('menu_id');
                newRow.querySelector('.name').textContent = formData.get('name');
                newRow.querySelector('.category').textContent = formData.get('category');
                newRow.querySelector('.description').textContent = formData.get('description');
                newRow.querySelector('.price').textContent = formData.get('price');
                
                document.getElementById('itemTableBody').appendChild(newRow);
                form.reset();
                bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
                showAlert('Item added successfully.', 'success');
              } else {
                // Error occurred
                showAlert('Error adding item. Please try again.', 'danger');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showAlert('Error adding item. Please try again.', 'danger');
            });
          }
        });


        // Delete item Button Click
        document.addEventListener('click', function(event) {
          if (event.target.classList.contains('delete-item')) {
            const itemId = event.target.closest('tr').querySelector('.item-id').value;
            const confirmation = confirm('Are you sure you want to delete this item?');

            if (confirmation) {
              fetch(`<?= base_url("item"); ?>/${itemId}`, {
                method: 'DELETE'
              })
              .then(response => response.json())
              .then(data => {
                if (data) {
                  // item deleted successfully
                  event.target.closest('tr').remove();
                  showAlert('Item deleted successfully.', 'success');
                } else {
                  // Error occurred
                  console.error('Error deleting item:', data.error);
                  showAlert('Error deleting item. Please try again.', 'danger');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                showAlert('Error deleting item. Please try again.', 'danger');
              });
            }
          }
        });
      });
      </script>
  </section>
  <?php endif; ?>

<?php if (!empty($table)) : ?>
  <section class="order">
    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="orderModalLabel">Edit Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="orderForm">
              
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="pending">pending</option>
                  <option value="completed">completed</option>
                  <option value="cancelled">cancelled</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="created_at" class="form-label">Created At</label>
                <input type="date" class="form-control" id="created_at" name="created_at" required>
              </div>
              <input type="hidden" id="orderId" name="order_id">
              <input type="hidden" id="tableId" name="table_id" value="<?= esc($table['id']) ?>">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary" id="saveOrder" aria-label="Save Order">Save</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Edit Order Button Click
      document.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit-order')) {
          const orderId = event.target.closest('tr').querySelector('.order-id').value;
          const tableId = event.target.closest('tr').querySelector('.table-id').value;
          const status = event.target.closest('tr').cells[2].textContent;
          const createdAt = event.target.closest('tr').cells[4].textContent;

          document.getElementById('orderModalLabel').textContent = 'Edit Order';
          document.getElementById('status').value = status;
          document.getElementById('created_at').value = createdAt;
          document.getElementById('orderId').value = orderId;
          document.getElementById('tableId').value = tableId;
        }
      });
      // Save Menu Button Click
      document.getElementById('saveOrder').addEventListener('click', function() {
        const form = document.getElementById('orderForm');
        const formData = new FormData(form);
        const orderId = formData.get('order_id');
        const data = Object.fromEntries(formData.entries());

        if (orderId) {
        // Update existing order
        fetch(`<?= base_url("order"); ?>/${orderId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)

        })
        .then(response => response.json())
        .then(data => {
          if (data) {
            // order updated successfully
            const row = document.querySelector(`.order-id[value="${orderId}"]`).closest('tr');
            row.cells[2].textContent = formData.get('status');
            row.cells[3].textContent = formData.get('created_at');
            bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();
            showAlert('Order updated successfully.', 'success');
          } else {
            // Error occurred
            console.log('Data is null or empty.');
            showAlert('Error updating order. Please try again.', 'danger');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showAlert('Error updating order. Please try again.', 'danger');
        });
      } 
      });
      
      // Delete order Button Click
      document.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-order')) {
          const orderId = event.target.closest('tr').querySelector('.order-id').value;
          const confirmation = confirm('Are you sure you want to delete this order?');

          if (confirmation) {
            fetch(`<?= base_url("order"); ?>/${orderId}`, {
              method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
              if (data) {
                // order deleted successfully
                event.target.closest('tr').remove();
                showAlert('Order deleted successfully.', 'success');
              } else {
                // Error occurred
                console.error('Error deleting order:', data.error);
                showAlert('Error deleting order. Please try again.', 'danger');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showAlert('Error deleting order. Please try again.', 'danger');
            });
          }
        }
      });
    </script>
  </section>
  <?php endif; ?>

<?= $this->endSection() ?>