<?php 
    namespace App\Service;
    use App\Entity\ApiSources;

    interface OpenWeatherMap {
        public function getDataOpenWeatherMap($city, $country);
    }

    interface WeatherStack {
        public function getDataWeatherStack($city, $country);
    }

    class ApiService implements OpenWeatherMap, WeatherStack {
        private $em;
        private $client;
        private $url;

        public function __construct($em, $client) {
            $this->em = $em;
            $this->client = $client;
        }

        public function getDataOpenWeatherMap($city, $country) {
            $this->url = $this->em->getRepository(ApiSources::class, 'deafult')->findById('2');

            $urlPath = $this->url->getUrl().'?appid='.$this->url->getApiKey().'&q='.$city.'&units='.'metric';
            
            $response = $this->client->request('GET', $urlPath);

            return [$response->getContent(), $this->url->getId()];
        }

        public function getDataWeatherStack($city, $country) {
            $this->url = $this->em->getRepository(ApiSources::class, 'deafult')->findById('1');
            
            $urlPath = $this->url->getUrl().'?access_key='.$this->url->getApiKey().'&query='.$city.','.$country;
            
            $response = $this->client->request('GET', $urlPath);

            return [$response->getContent(), $this->url->getId()];
        }
    }