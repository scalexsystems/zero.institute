<?php namespace Tests\Api;

use Scalex\Zero\Models\City;

class CitiesControllerTest extends \TestCase
{
    public function test_index_can_list_cities()
    {
        $this->getCity(2);

        $response = $this->actingAs($this->getUser())->json('GET', '/api/geo/cities');

        $cities = City::all();

        $response->assertStatus(200)
                 ->assertJsonStructure(['cities' => ['*' => ['name', 'state']]]);
        $this->seeResources($response, 'cities', $cities->modelKeys());
    }

    public function test_show_can_get_one_city()
    {
        $city = $this->getCity();

        $response = $this->actingAs($this->getUser())->json('GET', '/api/geo/cities/'.$city->id);

        $response->assertStatus(200)
                 ->assertJsonStructure(['city' => ['name', 'state']]);
    }

    /**
     * Create cities
     *
     * @param int $count
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\City|\Illuminate\Database\Eloquent\Collection
     */
    protected function getCity($count = 1, array $attributes = [])
    {
        $cities = factory(City::class, $count)->create($attributes);

        return $count === 1 ? $cities->first() : $cities;
    }
}
