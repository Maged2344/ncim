<?php

namespace Drupal\eca_views;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\eca\Event\AccessEventInterface;
use Drupal\eca\Event\TriggerEvent;
use Drupal\views\Views;

/**
 * Checks access for displaying configuration translation page.
 */
class AccessCheck implements AccessInterface {

  /**
   * CustomAccessCheck constructor.
   */
  public function __construct(
    protected TriggerEvent $triggerEvent,
    protected RouteMatchInterface $routeMatch,
  ) {}

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account): AccessResultInterface {
    $result = AccessResult::forbidden('No view available');
    $viewId = $this->routeMatch->getParameter('view_id');
    if ($viewId !== NULL) {
      $view = Views::getView($viewId);
      if ($view !== NULL) {
        $displayId = $this->routeMatch->getParameter('display_id');
        $view->setDisplay($displayId);
        $result = AccessResult::forbidden('No ECA configuration set an access result');
        $event = $this->triggerEvent->dispatchFromPlugin('eca_views:access', $view, $account);
        if ($event instanceof AccessEventInterface) {
          $eventResult = $event->getAccessResult();
          if ($eventResult !== NULL) {
            $result = $eventResult;
          }
        }
      }
    }
    return $result;
  }

}
