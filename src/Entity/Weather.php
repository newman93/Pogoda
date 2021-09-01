<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

interface OpenWeatherMap {
    public function getTemperatureOpenWeatherMap();
}

interface WeatherStack {
    public function getTemperatureWeatherStack();
}

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 */
class Weather implements OpenWeatherMap, WeatherStack
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Country;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="text")
     */
    private $Forecast;

    /**
     * @ORM\Column(type="integer")
     */
    private $ApiType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getForecast(): ?string
    {
        return $this->Forecast;
    }

    public function setForecast(string $Forecast): self
    {
        $this->Forecast = $Forecast;

        return $this;
    }

    public function getModelVersion(): ?int
    {
        return $this->ModelVersion;
    }

    public function setModelVersion(int $ModelVersion): self
    {
        $this->ModelVersion = $ModelVersion;

        return $this;
    }

    public function getApiType(): ?int
    {
        return $this->ApiType;
    }

    public function setApiType(int $ApiType): self
    {
        $this->ApiType = $ApiType;

        return $this;
    }

    public function getTemperatureOpenWeatherMap() {
        $forecast = json_decode($this->getForecast(), true);
                
        return isset($forecast['main']) ? (isset($forecast['main']['temp']) ? $forecast['main']['temp'] : null) : null;
    }

    public function getTemperatureWeatherStack() {
        $forecast = json_decode($this->getForecast(), true);

        return isset($forecast['current']) ? (isset($forecast['current']['temperature']) ? $forecast['current']['temperature'] : null) : null;
    }
}
