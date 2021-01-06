<?php

use Illuminate\Support\Facades\Route;

use App\User;
use App\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert', function () {
    // create a user
    User::create(['name' => 'user1', 'email' => 'user1@gmail.com', 'password' => bcrypt('user1@gmail.com')]);

    //create a role by the user above
    //Step 1: find user
    $user = User::findOrFail(1);
    //Step 2: create a role
    for ($i=1; $i<=5 ; $i+=1) { 
        $role = Role::create(['name' => 'role'.$i]);
        // Step 3: relationship
        $user->roles()->save($role);
    }

    echo 'Added Successful!';
});

Route::get('/read', function () {

    //Step 1: find user
    $user = User::findOrFail(1);
    //Step 2: find roles
    $roles = $user->roles;
    //Step 3: read
    foreach ($roles as $role) {
        echo $role->name . '<br/>';
    }
    echo 'Read Successful!';
});

Route::get('/update', function () {

    $user = User::findOrFail(1);

    if ($user->has('roles')) {

        foreach ($user->roles as $role) {

            if ($role->name == 'role1') {
                $role->name = 'role1 updated';
                $role->save();
            }
        }
    }

    echo 'Updated Successful!';
});

Route::get('/delete', function () {

    $user = User::findOrFail(1);

    if ($user->has('roles')) {

        foreach ($user->roles as $role) {
            $role::destroy(1);
        }
    }

    echo 'Deleted Successful!';
});

Route::get('/attach', function () {

    $user = User::findOrFail(1);

    $user->roles()->attach(4);

    echo 'Attached Successful!';
});

Route::get('/detech', function () {

    $user = User::findOrFail(1);

    $user->roles()->detach(4);

    echo 'Deteched Successful!';
});

Route::get('/sync', function () {

    $user = User::findOrFail(1);

    $user->roles()->sync([1,2,3,4,5]);

    echo 'Synced Successful!';
});