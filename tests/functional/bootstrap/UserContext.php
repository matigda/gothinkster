<?php

use User\Application\UseCase\Command\RegisterUserCommand;
use User\Application\Entity\User;
use User\Application\UseCase\Command\UpdateUserCommand;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use User\Application\UseCase\RegisterUserUseCase;


class UserContext implements Context
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var RegisterUserUseCase
     */
    private $registerUserUseCase;

    public function __construct(
        ContainerInterface $container,
        RegisterUserUseCase $registerUserUseCase
    ) {
        $this->container = $container;
        $this->registerUserUseCase = $registerUserUseCase;
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $this->schemaTool = new SchemaTool($em);
        $this->schemaTool->createSchema($em->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        $this->schemaTool->dropDatabase();
    }

    /**
     * @Given user from :fileName exists
     */
    public function userFromExists($fileName)
    {
        $userData = json_decode(file_get_contents(__DIR__ . '/../data/' . $fileName), true)['user'];

        $this->registerUserUseCase->execute(
            new RegisterUserCommand(
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['bio'] ?? null,
                $userData['image'] ?? null
            )
        );
    }


    /**
     * @When I send :method request on :url with data from :fileName
     */
    public function iUseMethodOnWithDataFrom($method, $url, $fileName)
    {
        $kernel = $this->container->get('kernel');

        $this->response = $kernel->handle(Request::create($url, $method, [], [], [], [], file_get_contents(__DIR__ . '/../data/' . $fileName)));
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
        Assert::assertEquals(
            json_decode(file_get_contents(__DIR__ . '/../data/' . $fileName), true),
            json_decode($this->response->getContent(), true)
        );
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
     * @When I send :method request on :url authenticated as :email
     * @When I send :method request on :url authenticated as :email with data from :fileName
     */
    public function iSendRequestOnAuthenticatedAs($method, $url, $email, $filename = null)
    {
        $kernel = $this->container->get('kernel');

        $request = $filename ?
            Request::create($url, $method, [], [], [], [], file_get_contents(__DIR__ . '/../data/' . $filename)) :
            Request::create($url, $method);
        $request->headers->set('Authorization', 'Token ' . $email);

        $this->response = $kernel->handle($request);
    }

    /**
     * @Then user is added to database
     */
    public function userIsAddedToDatabase()
    {
        Assert::assertEquals(
            1,
            count($this->container->get('doctrine')->getRepository(User::class)->findAll()),
            'Either user was not added to database or db driver has changed.'
        );
    }

}
