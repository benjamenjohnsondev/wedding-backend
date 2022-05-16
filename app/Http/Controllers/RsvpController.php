<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class RsvpController extends Controller
{
    public function updateUser(Request $request)
    {
        /** @var User $user */
        $user = JWTAuth::authenticate();
        if ($user) {
            // Iterate over form input and update user
            $content = json_decode($request->getContent());
            $guests = [];
            $mealChoices = [];
            foreach ($content as $key => $value) {
                if (in_array($key, $user->getFillable())) {
                    $user->$key = $value;
                } elseif (strpos($key, "name") === 0) {
                    $guests[$value]['guest_name'] = $value;
                } elseif (strpos($key, "starter") === 0) {
                    $name = substr($key, strlen("starter"));
                    $guests[$name]['starter'] = $value;
                } elseif (strpos($key, "main") === 0) {
                    $name = substr($key, strlen("main"));
                    $guests[$name]['main'] = $value;
                } elseif (strpos($key, "dessert") === 0) {
                    $name = substr($key, strlen("dessert"));
                    $guests[$name]['dessert'] = $value;
                }
            }

            if ($guests) {
                foreach ($guests as $name => $values) {
                    // [{"main": 2, "dessert": 1, "starter": 2, "guest_name": "Thalia Armstrong"}]
                    $mealChoices[] = $values;
                }
                $user['meal_choice'] = json_encode($mealChoices);
            } else {
                $user['meal_choice'] = json_encode([]);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Saved!'
            ]);
        }
    }

    private function bhdebug($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
        exit();
    }
}
