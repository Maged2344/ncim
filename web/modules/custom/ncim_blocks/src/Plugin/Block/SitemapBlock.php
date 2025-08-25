<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Sitemap Block.
 *
 * @Block(
 *   id = "sitemap_block",
 *   admin_label = @Translation("Sitemap Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class SitemapBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The menu tree service.
   *
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuTree;

  /**
   * Constructs a new SitemapBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Menu\MenuLinkTreeInterface $menu_tree
   *   The menu tree service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MenuLinkTreeInterface $menu_tree) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->menuTree = $menu_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu.link_tree')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_name = 'main';
    
    // Load the main menu tree.
    $menu_tree_parameters = new MenuTreeParameters();
    $menu_tree_parameters->setMaxDepth(3); // Limit to 3 levels deep
    $menu_tree_parameters->onlyEnabledLinks();
    
    $tree = $this->menuTree->load($menu_name, $menu_tree_parameters);
    
    // Debug: Check if menu exists
    if (empty($tree)) {
      return [
        '#markup' => '<p>' . $this->t('DEBUG: Main menu not found or empty. Menu name: @menu_name', ['@menu_name' => $menu_name]) . '</p>',
      ];
    }
    
    // Transform the tree into a renderable array.
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $this->menuTree->transform($tree, $manipulators);
    
    // Build the sitemap structure.
    $sitemap_items = $this->buildSitemapItems($tree);
    
    if (empty($sitemap_items)) {
      return [
        '#markup' => '<p>' . $this->t('خريطة الموقع غير متاحة في الوقت الحالي.') . '</p>',
      ];
    }

    return [
      '#theme' => 'sitemap_content',
      '#sitemap_items' => $sitemap_items,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Build sitemap items from menu tree.
   *
   * @param array $tree
   *   The menu tree array.
   *
   * @return array
   *   The sitemap items array.
   */
  protected function buildSitemapItems(array $tree) {
    $items = [];
    
    foreach ($tree as $element) {
      $item = [
        'title' => $element->link->getTitle(),
        'url' => $element->link->getUrlObject()->toString(),
        'has_children' => !empty($element->subtree),
      ];
      
      if (!empty($element->subtree)) {
        $item['children'] = $this->buildSitemapItems($element->subtree);
      }
      
      $items[] = $item;
    }
    
    return $items;
  }

}
