<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        return [
            'username' => $this->faker->username($gender),
            'name' => $this->faker->name($gender),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->phoneNumber,
            'email_verified_at' => now(),
            'avatar' => "20230312084615.jpg",
            'gender' => $gender,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
