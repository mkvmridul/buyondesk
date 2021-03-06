<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'college_name' => \App\datas::pluck('college_name')->random(),
		'password' => $password ?: $password = bcrypt('secret'),
		'remember_token' => str_random(10),
	];
});

$factory->define(App\sell::class, function (Faker\Generator $faker) {
	static $password;
	$type = array("book", "other")[array_rand(array("book", "other"))];
	return [
		'user_id' => App\User::all()->random()->id,
		'price' => rand(0, 1000),
		'title' => $faker->word,
		'discription' => $faker->paragraph(rand(1, 12)),
		'type' => $type,
		'author' => ($type == 'book') ? ($faker->name) : null,
		'degree_name' => App\category::pluck('degree_name')->random(),
		'condition' => array("new", "old", "good", "fine")[array_rand(array("new", "old", "good", "fine"))],
		'image_1' => $faker->image('public/storage/image', 400, 300, null, false),
		'image_2' => $faker->image('public/storage/image', 400, 300, null, false),
		'remember_token' => str_random(10),
	];
});
