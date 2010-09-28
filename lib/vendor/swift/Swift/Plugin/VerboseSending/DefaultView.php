<?

/**
 * Swift Mailer Verbose-sending Plugin Default View File.
 * Please read the LICENSE file
 * @author Chris Corbyn <chris@w3style.co.uk>
 * @package Swift_Plugin
 * @subpackage VerboseSending
 * @license GNU Lesser General Public License
 */

require_once dirname(__FILE__) . "/../../ClassLoader.php";
Swift_ClassLoader::load("Swift_Plugin_VerboseSending_AbstractView");

/**
 * The Default View for the Verbose Sending Plugin
 * @package Swift_Plugin
 * @subpackage VerboseSending
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class Swift_Plugin_VerboseSending_DefaultView extends Swift_Plugin_VerboseSending_AbstractView
{
  /**
   * Number of recipients painted
   * @var int
   */
  protected $count = 0;
  
  /**
   * Paint the result of a send operation
   * @param string The email address that was tried
   * @param boolean True if the message was successfully sent
   */
  public function paintResult($address, $result)
  {
    $this->count++;
    $color = $result ? "#51c45f" : "#d67d71";
    $result_text = $result ? "PASS" : "FAIL";
    ?>
    <div style="color: #ffffff; margin: 2px; padding: 3px; 
      font-weight: bold; background: <? echo $color; ?>;">
      <span style="float: right; text-decoration: underline;">
        <? echo $result_text; ?></span> 
      Recipient (<? echo $this->count; ?>): 
      <? echo $address; ?>
    </div>
    <?
    flush();
  }
}
