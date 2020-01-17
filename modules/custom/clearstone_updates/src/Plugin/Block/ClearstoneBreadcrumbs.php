<?php

namespace Drupal\clearstone_updates\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\webform\WebformInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Breadcrumbs Block' block.
 *
 * @Block(
 *  id = "clearstone_breadcrumbs_block",
 *  admin_label = @Translation("Clearstone: Breadcrumbs"),
 * )
 */
class ClearstoneBreadcrumbs extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The breadcrumb manager.
   *
   * @var \Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface
   */
  protected $breadcrumbManager;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;


  /**
   * Constructs a new SystemBreadcrumbBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface $breadcrumb_manager
   *   The breadcrumb manager.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, BreadcrumbBuilderInterface $breadcrumb_manager, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->breadcrumbManager = $breadcrumb_manager;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('breadcrumb'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $block = [];
    $breadcrumbs = [];
    $breadcrumbs['Home'] = '/';
    // Retrieve an array which contains the path pieces.
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);

    // Node pages
    $node = \Drupal::routeMatch()->getParameter('node');

    if (!empty($node)) {
      $node_id = $node->id();
      $type = $node->getType();
      $breadcrumbs['Home'] = '/';
      $node_title = strlen($node->getTitle()) > 120 ? substr($node->getTitle(), 0, 120) . "..." : $node->getTitle();
      // switch ($type) {
      //   case 'page':
          /* @var \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager */
          $menu_link_manager = \Drupal::service('plugin.manager.menu.link');

          $node_id = \Drupal::routeMatch()->getRawParameter('node');
          if($node_id){
            $menu_link = $menu_link_manager->loadLinksByRoute('entity.node.canonical', ['node' => $node_id]);
          }
          else{
            return '';
          }

          if (is_array($menu_link) && count($menu_link)){
            $menu_link = end($menu_link);
            if ($menu_link->getParent()) {
              $parents = array_reverse($menu_link_manager->getParentIds($menu_link->getParent()));
              foreach ($parents as $menu_key => $parent) {
                $title = $menu_link_manager->createInstance($parent)->getTitle();
                //kint($parents);
                $parent_node_id = $menu_link_manager->createInstance($parent)->getRouteParameters();
                $breadcrumbs[$title] = \Drupal::service('path.alias_manager')->getAliasByPath("/node/{$parent_node_id['node']}");
              }
            }
          }
          $load_node = Node::load($node_id);
          $breadcrumbs[$load_node->getTitle()] = '';

      //     break;
      //   default:
      //     break;
      // }
    }

    $excluded_pages = ['home'];
    if ($breadcrumbs && !in_array($path_args[1], $excluded_pages)) {
      $block['clearstone_breadcrumbs_block'] = [
        '#theme' => 'clearstone_breadcrumbs',
        '#breadcrumbs' => $breadcrumbs,
        '#cache' => ['contexts' => ['url.path', 'url.query_args']],
      ];
    }

    return $block;
  }
}
