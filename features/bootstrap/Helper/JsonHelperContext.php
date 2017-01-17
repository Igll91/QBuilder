<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 17.01.2017.
 * Time: 20:34
 */

namespace Svuk\Tests\Helper;

use AppBundle\Helper\JsonHelper;
use Behat\Behat\Context\Context;

class JsonHelperContext implements Context
{
    /**
     * @var JsonHelper
     */
    private $result;

    /**
     * @Given that I try to decode value :arg1
     */
    public function thatITryToDecodeValue($arg1)
    {
        $this->result = JsonHelper::decode($arg1);
    }

    /**
     * @Then status should be successful
     */
    public function statusShouldBeSuccessful()
    {
        \PHPUnit_Framework_Assert::assertEquals(JsonHelper::SUCCESS, $this->result->getStatus());
    }

    /**
     * @Then status should be empty
     */
    public function statusShouldBeEmpty()
    {
        \PHPUnit_Framework_Assert::assertEquals(JsonHelper::EMPTY_RESULT, $this->result->getStatus());
    }

    /**
     * @Then status should be failed
     */
    public function statusShouldBeFailed()
    {
        \PHPUnit_Framework_Assert::assertEquals(JsonHelper::FAILURE, $this->result->getStatus());
    }
}
