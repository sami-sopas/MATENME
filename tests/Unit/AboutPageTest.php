<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_the_user_can_see_the_about_page(): void
    {
       $response = $this->get('/about');

       //Comprobar que en la pagina esta el texto Hola Mundo
       $response->assertSee('Hola Mundo');

       //Si encuentro la pagina de about, devuelve status 200
       $response->assertStatus(200);
    }
}
