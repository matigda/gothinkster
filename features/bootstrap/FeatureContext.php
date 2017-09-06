<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @When I send :method request on :url with data from :fileName
     */
    public function iUseMethodOnWithDataFrom($method, $url, $fileName)
    {
        throw new PendingException();
    }

    /**
     * @Then I get :status http status
     */
    public function iGetHttpStatus($status)
    {
        throw new PendingException();
    }

    /**
     * @Then response body is same as in :fileName
     */
    public function responseBodyIsSameAsIn($fileName)
    {
        throw new PendingException();
    }

    /**
     * @When I send :method request on :url
     */
    public function iUseMethodOn($method, $url)
    {
        throw new PendingException();
    }

}
