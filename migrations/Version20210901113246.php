<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901113246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO api_sources (url, api_key) VALUES ('http://api.weatherstack.com/current', 'e3b3a272fd5d0f31dd1f6a99e6cdd913'), ('https://api.openweathermap.org/data/2.5/weather', '63ba173488a31302104f7f84d8250baf')");

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE api_sources');
    }
}
