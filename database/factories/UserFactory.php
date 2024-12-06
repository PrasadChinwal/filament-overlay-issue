<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use LdapRecord\Models\ActiveDirectory\User;
use Illuminate\Support\Facades\Hash;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'first_name' => $this->faker->word,
            'last_name' =>  $this->faker->word,
            'uin' =>  $this->faker->randomNumber(5, true),
            'netid' =>  $this->faker->word,
            'password' => Hash::make(Str::random(10)),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function getinfofromad($data)
    {
        $ad_user = null;

        if(isset($data['netid']))
        {
            try
            {
                $ad_user = User::findByOrFail('cn', $data['netid']);
            }
            catch (\Exception $e)
            {
            }
        }


        elseif(isset($data['uin']))
        {
            try
            {
                $ad_user = User::findByOrFail('extensionAttribute1', $data['uin']);
            }
            catch (\Exception $e)
            {
            }
        } 

        return $this->state(function (array $attributes) use ($ad_user) 
        {
            if(!is_null($ad_user))
            {
                return [
                    'name' => $ad_user['givenName'][0] . " " . $ad_user['sn'][0],
                    'netid' => $ad_user['cn'][0],
                    'email' => $ad_user['mail'][0],
                    'last_name' => $ad_user['sn'][0],
                    'first_name' => $ad_user['givenName'][0],
                    'uin' => $ad_user['extensionAttribute1'][0],
                ];
            }
            else
            {
                return [];
            }
        });
    }

}
