<?php 
    namespace App\Service;

    class WeatherService {
        public function getAvgTemperature($dataOpenWeatherMap, $dataWeatherStack) {
            if (is_null($dataOpenWeatherMap->getTemperatureOpenWeatherMap()) || is_null($dataWeatherStack->getTemperatureWeatherStack())) {
                return 'Brak danych';
            } else {
                return round(($dataOpenWeatherMap->getTemperatureOpenWeatherMap() + $dataWeatherStack->getTemperatureWeatherStack()) / 2, 0, PHP_ROUND_HALF_UP);
            }
        }        
    }    
