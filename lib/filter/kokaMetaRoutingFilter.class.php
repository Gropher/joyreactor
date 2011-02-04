<?php
/**
 * kokaMetaRoutingFilter allows adding noindex meta tag in routing.
 * In order to disable google indexing, add to routing.yml:
 *  param:
 *    noindex: true
 *
 * @package    symfony
 * @subpackage filter
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <sean@code-box.org>
 * @version    SVN: $Id: sfExecutionFilter.class.php 29523 2010-05-19 12:50:54Z fabien $
 */
class kokaMetaRoutingFilter extends sfFilter
{
  /**
   * Executes this filter.
   *
   * @param sfFilterChain $filterChain The filter chain
   */
  public function execute($filterChain)
  {
    $routing = $this->context->getRouting();
    $routes = $routing->getRoutes();
    $routeName = $routing->getCurrentRouteName();
    $variables = $routes[$routeName]->getDefaults();

    if(isset($variables['noindex']) && $variables['noindex'])
    {
      $this->context->getResponse()->addMeta('robots', 'noindex,nofollow');
    }

    $filterChain->execute();
  }
}
?>
