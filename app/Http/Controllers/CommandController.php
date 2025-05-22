<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function runCommand(Request $request)
    {
        // Get the command from the request
        $command = $request->input('command', 'list');

        try {
            // Run the command
            Artisan::call($command);

            // Capture the output
            $output = Artisan::output();
        } catch (\Exception $e) {
            $output = 'Error: ' . $e->getMessage();
        }

        // Return the output to the view
        return view('command', ['output' => $output, 'command' => $command]);
    }
}
