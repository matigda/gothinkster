<?php

use PHPUnit\Framework\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var MockHandler
     */
    protected $mockHandler;

    /**
     * @var Response
     */
    private $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @When I send :method request on :url with data from :fileName
     */
    public function iUseMethodOnWithDataFrom($method, $url, $fileName)
    {
        $kernel = $this->container->get('kernel');

        $this->response = $kernel->handle(Request::create($url, $method, json_decode(file_get_contents(__DIR__ . '/../data/' . $fileName), true)));
    }

    /**
     * @Then I get :status http status
     */
    public function iGetHttpStatus($status)
    {
        Assert::assertEquals($status, $this->response->getStatusCode());
    }

    /**
     * @Then response body is same as in :fileName
     */
    public function responseBodyIsSameAsIn($fileName)
    {
        Assert::assertEquals(file_get_contents(__DIR__ . '/../data/' . $fileName), $this->response->getContent());
    }

    /**
     * @When I send :method request on :url
     */
    public function iUseMethodOn($method, $url)
    {
        $kernel = $this->container->get('kernel');

        $this->response = $kernel->handle(Request::create($url, $method));
    }

    /**
     * @Then user is added to database
     */
    public function userIsAddedToDatabase()
    {
    }

}
