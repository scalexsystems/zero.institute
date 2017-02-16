<?php namespace Test\Api;

use Scalex\Zero\Models\City;

class CitiesControllerTest extends \TestCase
{
    public function test_index_can_list_cities()
    {
        $this->getCity(2);

        $this->actingAs($this->getUser())->get('/api/geo/cities');

        $cities = City::all();

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['cities' => ['*' => ['name', 'state']]])
             ->seeResources('cities', $cities->modelKeys());
    }

    public function test_show_can_get_one_city()
    {
        $city = $this->getCity();

        $this->actingAs($this->getUser())->get('/api/geo/cities/'.$city->id);

        $this->assertResponseStatus(200)
             ->seeJsonStructure(['city' => ['name', 'state']]);
    }

    /**
     * Create cities
  
*
*@param int $count
     * @param array $attributes
     
      
*
*@return \Scalex\Zero\Models\City|\Illuminate\Database\Eloquent\Collection
     */
    protected function getCity($count = 1, array $attributes = [])
    {
        return factory(City::class, $count)->create($attributes);
    }
}
