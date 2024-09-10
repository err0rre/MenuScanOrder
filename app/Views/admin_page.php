<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<body>
<main>
    <section class="py-5" aria-labelledby="user-management-heading">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 id="user-management-heading">User Management - Admin Panel</h2>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-lg-0">
                    <form method="get" action="<?= base_url('admin_page/'); ?>">
                        
                        <div class="input-group">
                            <label for="search-input" class="visually-hidden">Search</label>
                            <input type="text" class="form-control" placeholder="Enter your search..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <a class="btn btn-primary" href="<?= base_url('admin_page/addedit');?>" aria-label="Add User">Add User</a>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped" aria-describedby="user-management-heading">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user['id']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['status']) ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="<?= base_url('restaurant_user/'.$user['id']);?>" aria-label="View User <?= esc($user['username']) ?>"><i class="bi bi-eye-fill"></i></a>
                                    <a class="btn btn-sm btn-primary me-2" href="<?= base_url('admin_page/addedit/'.$user['id']);?>"><i class="bi bi-pencil-fill" aria-label="Edit User <?= esc($user['username']) ?>"></i></a>
                                    <a class="btn btn-sm btn-warning me-2" href="<?= base_url('admin_page/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" aria-label="Delete User <?= esc($user['username']) ?>"><i class="bi bi-dash-circle-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</main>
</body>

    <!-- This script includes all of Bootstrap's JavaScript-based components and behaviors, such as modal windows, dropdowns, and tooltips.  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>

<?= $this->endSection() ?>