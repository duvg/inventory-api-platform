<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestBase extends WebTestCase
{
    use RecreateDatabaseTrait;

    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    private $testClient = null;

    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $carlos = null;
    protected static ?KernelBrowser $duviel = null;
    protected static ?KernelBrowser $esther = null;

    protected function setUp(): void
    {

        //$this->databaseTool = $this->testClient->getContainer()->get(DatabaseToolCollection::class)->get();

        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/ld+json',
                ]
            );
        }

        if (null === self::$carlos) {
            self::$carlos = clone self::$client;
            $this->createAuthenticatedUser(self::$carlos, 'carlos@test.com');
        }

        if (null === self::$duviel) {
            self::$duviel = clone self::$client;
            $this->createAuthenticatedUser(self::$duviel, 'duviel@test.com');
        }

        if (null === self::$esther) {
            self::$esther = clone self::$client;
            $this->createAuthenticatedUser(self::$esther, 'esther@test.com');
        }

    }

    protected function createAuthenticatedUser(KernelBrowser &$client, string $email): void
    {
        $user = $this->getContainer()->get('App\Repository\UserRepository')->findOneByEmailOrFail($email);
        $token = $this
            ->getContainer()
            ->get('Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface')
            ->create($user);

        $client->setServerParameters(
            [
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json',
            ]
        );
    }

    protected function getResponseData(Response $response): array
    {
        return \json_decode($response->getContent(), true);
    }

    protected function initDbConnection(): Connection
    {
        return $this->getContainer()->get('doctrine')->getConnection();
    }

    /**
     * @return false|mixed
     *
     * @throws Exception
     */
    protected function getCarlosId()
    {
        return $this->initDbConnection()->fetchOne('SELECT id FROM user WHERE email = "carlos@test.com"');
    }

    /**
     * @return false|mixed
     *
     * @throws Exception
     */
    protected function getDuvielId()
    {
        return $this->initDbConnection()->fetchOne('SELECT id FROM user WHERE email = "duviel@test.com"');
    }

    /**
     * @return false|mixed
     *
     * @throws Exception
     */
    protected function getEstherId()
    {
        return $this->initDbConnection()->fetchOne('SELECT id FROM user WHERE email = "esther@test.com"');
    }
}
