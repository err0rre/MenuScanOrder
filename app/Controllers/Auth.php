<?php namespace App\Controllers;

use Google\Client as GoogleClient;

class Auth extends BaseController
{
    // Protected properties can be accessed within the class and by classes derived from that class
    protected $client;   // Will hold the instance of the Google Client
    protected $base_url; // Will hold the base URL of the app from the environment variables

    /**
     * Class constructor.
     */
    public function __construct()
    {
        // Store the base URL in the class property from the .env file
        $this->base_url = getenv('app.baseURL');

        // Instantiate the Google Client and set it up with the necessary details
        $this->client = new GoogleClient();
        $this->client->setClientId(getenv('GOOGLE_CLIENT_ID'));        // Set the Google Client ID from .env
        $this->client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET')); // Set the Google Client Secret from .env
        $this->client->setRedirectUri($this->base_url . '/login/callback'); // Set the Redirect URI for Google OAuth callback
        $this->client->addScope("email");   // Request access to user's email
        $this->client->addScope("profile"); // Request access to user's basic profile info
    }

    /**
     * Initiates Google OAuth login process.
     */
    public function google_login()
    {
        // Get the authentication URL from the Google Client
        $authUrl = $this->client->createAuthUrl();
        // Redirect the user to Google's OAuth server
        return redirect()->to($authUrl);
    }

    /**
     * Google OAuth callback function.
     */
    public function google_callback()
    {
        // Fetch the access token using the authorization code received from Google
        $token = $this->client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
        // Set the access token to the Google Client
        $this->client->setAccessToken($token);

        // Create a new Google Oauth2 service instance
        $google_oauth = new \Google\Service\Oauth2($this->client);
        // Get user information from Google
        $google_account_info = $google_oauth->userinfo->get();

        // Load the user model to interact with the database
        $userModel = new \App\Models\UserModel();
        // Check if the user's email exists in the database
        $user = $userModel->where('email', $google_account_info->email)->first();

        if (!$user) {
            // If the user doesn't exist, create a new user with the info from Google
            $newData = [
                'email' => $google_account_info->email,
                'username' => $google_account_info->name,
                'isAdmin' => false, // Default new user as not an admin
            ];
            $userModel->insert($newData);
            // Retrieve the newly created user info
            $user = $userModel->where('email', $google_account_info->email)->first();
        }

        // Set user information in the session
        session()->set([
            'isLoggedIn' => true,
            'userId' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
            'isAdmin' => $user['isAdmin'] // Assumes 'isAdmin' field is a boolean in your user table
        ]);

        // Redirect user to the admin dashboard if they are an admin, otherwise to their resume page
        if (session()->get('isAdmin')) {
            return redirect()->to('/admin_page');
        } else {
            return redirect()->to('/restaurant_user/' . session()->get('userId'));
            //return redirect()->to('/admin_page');
        }
    }

    /**
     * Logs the user out by clearing session data.
     */
    public function logout()
    {
        // Access the session service
        $session = session();
        
        // Remove specific session variables
        $session->remove(['isLoggedIn', 'userId', 'email', 'username', 'isAdmin']);
        
        // Redirect the user to the homepage
        return redirect()->to('/');
    }
}