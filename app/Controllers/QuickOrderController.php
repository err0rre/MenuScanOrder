<?php namespace App\Controllers;

use CodeIgniter\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class QuickOrderController extends BaseController
{
   
    /**
     * Constructor. Loads necessary helpers and initializes session.
     */
    public function __construct()
    {
        helper('url'); 
        $this->session = session();
    }

    /**
     * Displays the landing page.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
       return view('landing_page');
    }

    /**
     * Displays the admin page with a list of users. Supports search functionality.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function admin_page()
    {
        // Creates an instance of the UserModel class.
        // It's important to use the fully qualified namespace to ensure the correct class is instantiated.
        $model = new \App\Models\UserModel();

        // Get the value of the 'search' query parameter from the request
        $search = $this->request->getGet('search');

        // If the search query is not empty
        if (!empty($search)) {
            $users = $model->like('username', $search)
                           ->orLike('email', $search)
                           ->orderBy('username', 'ASC')
                           ->findAll();
        } else {
            $users = $model->orderBy('username', 'ASC')->findAll();
        }
        
        // Store the retrieved users in the $data array
        $data['users'] = $users;
        
        // Load the 'admin' view and pass the $data array to it
        return view('admin_page', $data);
    }

    /**
     * Displays the add/edit user form and handles form submission.
     *
     * @param int|null $id User ID (null for adding a new user)
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function addedit($id = null)
    {
        $model = new \App\Models\UserModel();
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();

            if ($id === null) {
                if ($model->insert($data)) {
                    $this->session->setFlashdata('success', 'User added successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to add user. Please try again.');
                }
            } else {
                if ($model->update($id, $data)) {
                    $this->session->setFlashdata('success', 'User updated successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to update user. Please try again.');
                }
            }
            return redirect()->to('/admin_page');
        }

         $data['user'] = ($id === null) ? null : $model->find($id);
        return view('addedit', $data);
     }

     /**
     * Deletes a user.
     *
     * @param int $id User ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id)
    {
        $model = new \App\Models\UserModel();

        if ($model->delete($id)) {
            $this->session->setFlashdata('success', 'User deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Failed to delete user. Please try again.');
        }
        return redirect()->to('/admin_page');
    }

    /**
     * Displays the user view with associated restaurant, menus, tables, items, and orders.
     *
     * @param int $id User ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function restaurant_user($id)
    {
        $userModel = new \App\Models\UserModel();
        $restaurantsModel = new \App\Models\RestaurantsModel();
        $itemModel = new \App\Models\ItemModel();
        $menuModel = new \App\Models\MenuModel();
        $orderModel = new \App\Models\OrderModel();
        $tableModel = new \App\Models\TableModel();

        // Fetch data details
        $data['user'] = $userModel->find($id);
        
        // Ensure user exists
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User Not Found');
        }

        // Fetch restaurant_id associated with the user
        $data['restaurant'] = $restaurantsModel->where('user_id', $id)->first();

        // Fetch related data for each restaurant
        if (!empty($data['restaurant'])) {
            $restaurant_id = $data['restaurant']['id'];
            $data['menus'] = $menuModel->where('restaurant_id', $restaurant_id)->findAll();
            $data['tables'] = $tableModel->where('restaurant_id', $restaurant_id)->findAll();
            // Fetch the maximum table number for the given restaurant
            $tablesCount = $tableModel->where('restaurant_id', $restaurant_id)->countAllResults();
            $data['tablesCount'] = $tablesCount;

            // Fetch items associated with each menu
            foreach ($data['menus'] as $menu) {
                $menuId = $menu['id'];
                $items = $itemModel->where('menu_id', $menuId)->findAll();
                $data['items'][$menuId] = $items;
            }

            // Fetch orders based on table_id
            foreach ($data['tables'] as $table) {
                $tableId = $table['id'];
                $orders = $orderModel->where('table_id', $tableId)->findAll();
                $data['orders'][$tableId] = $orders;
            }
        } 
        return view('user_view', $data);
    }

    /**
     * Displays the menu view with associated restaurant, items, and categories.
     *
     * @param int $id Menu ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function menu($id)
    {
        $userModel = new \App\Models\UserModel();
        $restaurantsModel = new \App\Models\RestaurantsModel();
        $itemModel = new \App\Models\ItemModel();
        $menuModel = new \App\Models\MenuModel();
        $orderModel = new \App\Models\OrderModel();
        $tableModel = new \App\Models\TableModel();

        // Fetch data details
        $data['menu'] = $menuModel->find($id);
        
        // Ensure menu exists
        if (!$data['menu']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu Not Found');
        }

        // Fetch restaurant_id associated with the menu
        $restaurant_id = $data['menu']['restaurant_id'];

        // Fetch related data using restaurant_id
        $data['restaurants'] = $restaurantsModel->where('id', $restaurant_id)->first();
        $data['menus'] = $menuModel->where('restaurant_id', $restaurant_id)->findAll();
        $data['tables'] = $tableModel->where('restaurant_id', $restaurant_id)->findAll();

        $data['restaurant_name'] = $data['restaurants']['name'];
        
        // Fetch items associated with each menu
        foreach ($data['menus'] as $menu) {
            $menuId = $id;
            $items = $itemModel->where('menu_id', $menuId)->findAll();
            $data['items'][$menuId] = $items;

            // store categories of items
            $categories = [];
            foreach ($items as $item) {
                $categories[$item['category']][] = $item;
            }
            $data['categories'] = $categories;
        }
        return view('customer_scan_page', $data);
    }
}