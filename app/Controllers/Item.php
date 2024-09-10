<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ItemModel;

class Item extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list Item entries or filter by menu_id.
     */
    public function index()
    {
        $model = new ItemModel();

        // Retrieve 'menu_id' from query parameters if provided.
        $menuId = $this->request->getGet('menu_id');

        // Filter the data by menu_id if provided, otherwise retrieve all entries.
        $data = $menuId ? $model->where('menu_id', $menuId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single Item entry by its ID.
     */
    public function show($id = null)
    {
        $model = new ItemModel();

        // Attempt to retrieve the specific Item entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Item entry found with ID: {$id}");
        }

    }

    /**
     * Handle POST requests to create a new Item entry.
     */
    public function create()
    {
        $model = new ItemModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Item data created successfully.');
        } else {
            return $this->failServerError('Failed to create Item data.');
        }
    }

    /**
     * Handle PUT requests to update an existing Item entry by its ID.
     */
    public function update($id = null)
    {
        $model = new ItemModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Item entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Item data updated successfully.');
        } else {
            return $this->failServerError('Failed to update Item data.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing Item entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new ItemModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Item entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Item data deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Item data.');
        }
    }
}