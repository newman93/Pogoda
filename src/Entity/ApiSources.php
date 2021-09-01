<?php

namespace App\Entity;

use App\Repository\ApiSourcesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiSourcesRepository::class)
 */
class ApiSources
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
    private $Url;

    /**
     * @ORM\Column(type="text")
     */
    private $ApiKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(string $Url): self
    {
        $this->Url = $Url;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->ApiKey;
    }

    public function setApiKey(string $ApiKey): self
    {
        $this->ApiKey = $ApiKey;

        return $this;
    }
}
