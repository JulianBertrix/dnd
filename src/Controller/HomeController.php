<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $city;

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        //à l'arrivé du visiteur et à chaque rechargement de page,
        //par defaut, nous affichons la meteo de Montpellier
        $this->city = "Montpellier";
        //requete sur l'api d'OpenWeatherMap
        $url = "http://api.openweathermap.org/data/2.5/weather?q=".$this->city."&units=metric&appid=7066fbd2464f15776cf2df43d20aab57";
        $data = file_get_contents($url);
        $json = json_decode($data, true);

        //recupération des données à afficher
        $temp = $json['main']['temp'];//température
        $humidity = $json['main']['humidity'];//humidité
        $icon = $json['weather'][0]['icon'];//icone

        return $this->render('home/index.html.twig', [
            'city' => $this->city,
            'temperature' => (int)$temp,
            'humidity' => $humidity,
            'icon' => $icon
        ]);
    }

    /**
     * @Route("/search/city/weather", name="city_weather")
     */
    public function searchCityWeather(Request $request){
        //recupération des super globals
        $post = $request->request->all();

        //affectation de la variable privée city à la valeur envoyé 
        //via la requete HTTP de type post
        $this->city = $post['city'];
        //requete sur l'api d'OpenWeatherMap
        $url = "http://api.openweathermap.org/data/2.5/weather?q=".$this->city."&units=metric&appid=7066fbd2464f15776cf2df43d20aab57";
        $data = file_get_contents($url);
        $json = json_decode($data, true);

        //recupération des données à afficher
        $temp = $json['main']['temp'];//température
        $humidity = $json['main']['humidity'];//humidité
        $icon = $json['weather'][0]['icon'];//icone

        //renvoie des données en json pour un traitement asynchrone.
        //voir la méthode getCity dans le fichier searchCity.js 
        return $this->json([
            'city' => $this->city,
            'temperature' => (int)$temp,
            'humidity' => $humidity,
            'icon' => $icon
        ]);
    }   
}
