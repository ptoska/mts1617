<?php
// features/bootstrap/FeatureContext.php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class FeatureContext implements SnippetAcceptingContext
{
    private $stack;
    private $web;

    public function __construct()
    {
        $this->web = new Web();
    }
    
    /**
     * @Given there is a stack
     */
    public function thereIsAStack()
    {
        $this->stack = new Stack();
    }

    /**
     * @When I add subject :arg1
     */
    public function iAddSubject($arg1)
    {
        $this->stack->push($arg1);
    }

    /**
     * @When I remove an elemenet from stack
     */
    public function iRemoveAnElemenetFromStack()
    {
        $this->stack->pop();
    }

    /**
     * @Then I should have :arg1 at top of stack
     */
    public function iShouldHaveAtTopOfStack($arg1)
    {
        PHPUnit_Framework_Assert::assertSame(
            $arg1,
            $this->stack->top()
        );
    }

    /**
     * @When the stack has :arg1 element
     */
    public function theStackHasElement($arg1)
    {
        PHPUnit_Framework_Assert::assertCount(
            intval($arg1),
            $this->stack
        );
    }

    /**
     * @Given there is a website :arg1
     */
    public function thereIsAWebsite($arg1)
    {
        $this->web->visit($arg1);
    }

    /**
     * @When I fill field :arg1 with value :arg2
     */
    public function iFillFieldWithValue($arg1, $arg2)
    {
        $this->web->fillField($arg1,$arg2);
    }

    /**
     * @When I check field :arg1
     */
    public function iCheckField($arg1)
    {
        $this->web->checkField($arg1);
    }

    /**
     * @When I click button :arg1
     */
    public function iClickButton($arg1)
    {
        $this->web->clickButton($arg1);
    }

    /**
     * @Then I should have content :arg1
     */
    public function iShouldHaveContent($arg1)
    {
        PHPUnit_Framework_Assert::assertTrue(
            $this->web->hasContet($arg1)
        );
    }

    /**
     * @When I submit form :arg1
     */
    public function iSubmitForm($arg1)
    {
        $this->web->submitForm($arg1);
    }

    /**
     * @When I press button :arg1
     */
    public function iPressButton($arg1)
    {
        $this->web->pressButton($arg1);
    }

    /**
     * @Then close connection
     */
    public function closeConnection()
    {
        $this->web->closeConnection();
    }
}
