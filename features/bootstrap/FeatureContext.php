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
     * @When I use :arg1 method on :arg2 with data from :arg3
     */
    public function iUseMethodOnWithDataFrom($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then I get :arg1 http status
     */
    public function iGetHttpStatus($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then response body is same as in :arg1
     */
    public function responseBodyIsSameAsIn($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I use :arg1 method on :arg2
     */
    public function iUseMethodOn($arg1, $arg2)
    {
        throw new PendingException();
    }

}
