<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;

class Order extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list Order entries or filter by table_id.
     */
    public function index()
    {
        $model = new OrderModel();

        // Retrieve 'table_id' from query parameters if provided.
        $tableId = $this->request->getGet('table_id');

        // Filter the data by table_id if provided, otherwise retrieve all entries.
        $data = $tableId ? $model->where('table_id', $tableId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single Order entry by its ID.
     */
    public function show($id = null)
    {
        $model = new OrderModel();

        // Attempt to retrieve the specific Order entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Order entry found with ID: {$id}");
        }
    }

    /**
     * Handle POST requests to create a new Order entry.
     */
    public function create()
    {
        $model = new OrderModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Order data created successfully.');
        } else {
            return $this->failServerError('Failed to create Order data.');
        }
    }

    /**
     * Handle PUT requests to update an existing Order entry by its ID.
     */
    public function update($id = null)
    {
        $model = new OrderModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Order data updated successfully.');
        } else {
            return $this->failServerError('Failed to update Order data.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing Order entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new OrderModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Order data deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Order data.');
        }
    }
}