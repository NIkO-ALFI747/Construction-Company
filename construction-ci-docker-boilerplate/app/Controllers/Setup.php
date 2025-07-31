<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI; // For CLI output if needed

class Setup extends Controller
{
    public function seedDatabase()
    {
        // Prevent running in production environment via web route for security
        if (ENVIRONMENT === 'production') {
            return $this->response->setStatusCode(403)->setBody('Access denied in production environment.');
        }

        $seeder = \Config\Database::seeder();

        try {
            // Run the DatabaseSeeder
            $seeder->call('DatabaseSeeder');
            $message = "Database successfully initialized.";
            $status = "success";
        } catch (\Exception $e) {
            $message = "Error initializing database: " . $e->getMessage();
            $status = "error";
        }

        $data['message'] = $message;
        $data['status'] = $status;
        // Return a simple HTML response
        return $this->response->setBody(view('setup', $data));
    }
}