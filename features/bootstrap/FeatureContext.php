<?php

require("Thing.php");

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
  /**
     * @Given /^I am in a directory "([^"]*)"$/
     */
     public function iAmInADirectory($dir)
     {
       if (!file_exists($dir)) {
         mkdir($dir);
       }
       chdir($dir);
     }

     /** @Given /^I have a file named "([^"]*)"$/ */
     public function iHaveAFileName($file)
     {
       touch($file);
     }

     /** @When /^I run "([^"]*)"$/ */
     public function iRun($command)
     {
       exec($command, $output);
       $this->output = trim(implode("\n", $output));
     }

     /** @Then /^I should get:$/ */
     public function iShouldGetList(PyStringNode $string)
     {
       if ((string) $string !== $this->output) {
         throw new Exception(
           "Actual output is:\n" . $this->output
         );
       }
     }
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    // public function __construct(array $parameters)
    // {
    //     // Initialize your context here
    // }

//
// Place your definition and hook methods here:
//
  private $Thing;
   /**
    * @Given /^I have the number (\d+) and the number (\d+)$/
    */
   public function iHaveTheNumberAndTheNumber($a, $b)
   {
       $this->Thing = new Thing($a, $b);
   }
   /**
    * @When /^I add them together$/
    */
    public function iAddThemTogether() {
      $this->Thing->add();
    }
  /**
   * @Then /^I should get (\d+)$/
   */
   public function iShouldGetSum($sum) {
     if ($this->Thing->sum != $sum) {
       throw new Exception("Actual sum: ".$this->Thing->sum);
     }
     $this->Thing->display();
   }
//
}
