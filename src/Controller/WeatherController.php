<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiService;
use App\Service\WeatherService;
use App\Service\CacheService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'weather')]
    public function index(Request $request, 
        EntityManagerInterface $entityManager, 
        HttpClientInterface $client,
        CacheService $cacheService,
        WeatherService $weatherService): Response
    {
        $weather = new Weather();
        $api = new ApiService($entityManager, $client);

        $form = $this->createForm(WeatherType::class, $weather);

        $form->handleRequest($request);

        $data = [];
        $temperature = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $cacheService->clearCache();
            $temperature = $cacheService->getDataIfExist($data);

            if ($temperature  == '') {
                $apiDataOpenWeatherMap = $api->getDataOpenWeatherMap($data->getCity(), $data->getCountry());
                $apiDataWeatherStack = $api->getDataWeatherStack($data->getCity(), $data->getCountry());

                $weatherOWM = new Weather();
                
                $weatherOWM->setCity($data->getCity());
                $weatherOWM->setCountry($data->getCountry());
                $weatherOWM->setDate(new \DateTime());
                $weatherOWM->setForecast($apiDataOpenWeatherMap[0]);
                $weatherOWM->setApiType($apiDataOpenWeatherMap[1]);

                $entityManager->persist($weatherOWM);
                $entityManager->flush();   
                
                $weatherWS = new Weather();
                
                $weatherWS->setCity($data->getCity());
                $weatherWS->setCountry($data->getCountry());
                $weatherWS->setDate(new \DateTime());
                $weatherWS->setForecast($apiDataWeatherStack[0]);
                $weatherWS->setApiType($apiDataWeatherStack[1]);

                $entityManager->persist($weatherWS);
                $entityManager->flush();   
                
                $temperature = $weatherService->getAvgTemperature($weatherOWM, $weatherWS);

                if ($file = fopen(realpath('../src/Cache/temperature.txt'), "a")) {
                    $line = $data->getCity().";".$data->getCountry().";".$temperature.";".(new \DateTime())->modify("+1 minutes")->format('Y-m-d H:i:s');
                    fwrite($file, $line);
                    fclose($file);
                }
            }
        }


        return $this->render('weather/index.html.twig', [
            'form' => $form->createView(),
            'temperature' => $temperature,
            'controller_name' => 'WeatherController',
        ]);
    }
}
