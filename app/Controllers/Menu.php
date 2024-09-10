<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;

class Menu extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list Menu entries or filter by restaurant_id.
     */
    public function index()
    {
        $model = new MenuModel();

        // Retrieve 'restaurant_id' from query parameters if provided.
        $restaurantId = $this->request->getGet('restaurant_id');

        // Filter the data by restaurant_id if provided, otherwise retrieve all entries.
        $data = $restaurantId ? $model->where('restaurant_id', $restaurantId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single Menu entry by its ID.
     */
    public function show($id = null)
    {
        $model = new MenuModel();

        // Attempt to retrieve the specific Menu entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Menu entry found with ID: {$id}");
        }

    }

    /**
     * Handle POST requests to create a new Menu entry.
     */
    public function create()
    {
        $model = new MenuModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Menu data created successfully.');
        } else {
            return $this->failServerError('Failed to create Menu data.');
        }
    }

    /**
     * Handle PUT requests to update an existing Menu entry by its ID.
     */
    public function update($id = null)
    {
        $model = new MenuModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Menu entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Menu data updated successfully.');
        } else {
            return $this->failServerError('Failed to update Menu data.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing Menu entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new MenuModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Menu entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Menu data deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Menu data.');
        }
    }
}