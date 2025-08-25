<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides a Social Media Footer Block.
 *
 * @Block(
 *   id = "social_media_footer_block",
 *   admin_label = @Translation("Social Media Footer Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class SocialMediaFooterBlock extends BlockBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SocialMediaFooterBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    try {
      // Query for published social media nodes, ordered by display order.
      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'social_media')
        ->condition('status', 1)
        ->sort('field_display_order', 'ASC')
        ->accessCheck(FALSE);

      $nids = $query->execute();

      if (empty($nids)) {
        return [
          '#markup' => '<p>No social media links configured.</p>',
          '#cache' => [
            'max-age' => 0,
          ],
        ];
      }

      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      $social_links = [];

      /** @var NodeInterface[] $nodes */
      foreach ($nodes as $node) {
        /** @var NodeInterface $node */
        $icon_class = $node->get('field_icon_class')->value ?? '';
        $link_url = $node->get('field_link_url')->uri ?? '';
        $title = $node->get('title')->value ?? '';

        if ($icon_class && $link_url) {
          $social_links[] = [
            'icon_class' => $icon_class,
            'url' => $link_url,
            'title' => $title,
          ];
        }
      }

      if (empty($social_links)) {
        return [
          '#markup' => '<p>No social media links configured.</p>',
          '#cache' => [
            'max-age' => 0,
          ],
        ];
      }

      // Build HTML for social media section
      $social_links_html = '';
      foreach ($social_links as $link) {
        $social_links_html .= '
          <li class="nav-item">
            <a class="nav-link action-icon" href="' . $link['url'] . '" title="' . $link['title'] . '" target="_blank" rel="noopener">
              <i class="' . $link['icon_class'] . '"></i>
            </a>
          </li>';
      }

      $html = '
        <h3 class="fs-18 fw-700 text-primary-paragraph">' . $this->t("تابعنا على") . '</h3>
        <hr class="border-neutral-secondary border-2">
        <ul class="nav gap-2 ps-0 mb-5">
          ' . $social_links_html . '
        </ul>
        <h3 class="fs-18 fw-700 text-primary-paragraph">' . $this->t("أدوات الاتاحة والوصول") . '</h3>
        <hr class="border-neutral-secondary border-2">
        <ul class="nav gap-2 ps-0">
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="toggle-visibility" title="' . $this->t("Toggle visibility") . '">
              <i class="fa-regular fa-eye"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="zoom-in" title="' . $this->t("Zoom in") . '">
              <i class="fa-regular fa-magnifying-glass-plus"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="zoom-out" title="' . $this->t("Zoom out") . '">
              <i class="fa-regular fa-magnifying-glass-minus"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="text-to-speech" title="' . $this->t("Text to speech") . '">
              <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.93905 16.9301C7.88988 16.9301 7.84069 16.9242 7.79069 16.9126C7.45569 16.8309 7.24988 16.4926 7.33154 16.1576C7.41571 15.8118 7.81817 14.6267 9.45483 13.9159C9.474 13.9076 9.494 13.9 9.514 13.8934C9.53816 13.8825 9.5665 13.87 9.60067 13.8584C10.2973 13.6017 11.1599 13.1651 11.4874 12.9017C11.5032 12.8892 11.5199 12.8768 11.5374 12.8659L13.8665 11.3459C13.9074 11.3084 13.9065 11.2901 13.9057 11.2834C13.9023 11.2234 13.8349 11.0976 13.6924 11.0051C12.6465 10.3093 11.6798 10.7134 10.2115 11.4617C10.1107 11.5134 10.0098 11.565 9.90902 11.615C9.11485 12.0084 8.13654 11.9501 7.35238 11.4634C6.60821 11.0018 6.16406 10.2325 6.16406 9.40671C6.16406 8.58088 6.60823 7.80592 7.41406 7.25925C8.54406 6.49342 10.2415 6.25093 11.3807 6.68926L13.1824 7.21506C13.3507 7.26506 13.5248 7.24592 13.674 7.16176C13.819 7.08009 13.9215 6.94843 13.9632 6.79009C14.0415 6.49759 13.8781 6.19506 13.584 6.08339L11.6199 5.35089C11.6199 5.35089 11.6165 5.3492 11.614 5.34836L10.8724 5.1209C10.2624 4.93841 9.82152 4.87086 9.49235 4.91086C8.93652 4.98003 7.4499 5.63674 6.64323 6.03424C6.33406 6.18674 5.95906 6.06006 5.80656 5.75006C5.65406 5.44089 5.78066 5.06589 6.09066 4.91339C6.32316 4.79839 8.39232 3.78839 9.34066 3.67006C9.84899 3.60839 10.4507 3.6901 11.2357 3.9251L11.9941 4.15761C12.0024 4.16011 12.0107 4.16258 12.019 4.16591C12.0257 4.16841 12.0332 4.1709 12.0399 4.1734L12.0515 4.17755C12.204 4.23255 12.3674 4.22505 12.5124 4.15671C12.664 4.08588 12.7774 3.9576 12.8324 3.79677C12.9399 3.4876 12.7874 3.15091 12.4849 3.02675L10.9023 2.37253L10.7673 2.32257C10.3198 2.15757 10.0732 2.06753 9.85067 2.01503C9.574 1.9517 9.26738 1.92255 8.94238 1.93088L8.91903 1.93259C8.83736 1.93759 8.79155 1.94093 8.61239 1.97759C8.60572 1.97926 8.59903 1.9801 8.59237 1.98093C8.41487 2.01093 8.31566 2.04422 8.09733 2.11838L7.66903 2.26422C6.24319 2.74922 5.6524 2.95006 5.03906 3.39589C3.41323 4.58172 2.42734 5.9317 2.17318 6.7442C1.90234 7.61086 1.90234 8.67588 1.90234 10.7992L1.90234 16.3076C1.90234 16.6526 1.62234 16.9326 1.27734 16.9326C0.932344 16.9326 0.652344 16.6526 0.652344 16.3076L0.652344 10.7992C0.652344 8.55004 0.652318 7.42089 0.979818 6.37172C1.44815 4.87839 3.00322 3.33421 4.30322 2.38588C5.07156 1.82838 5.80485 1.57843 7.26652 1.08176L7.69735 0.935033C7.93318 0.855033 8.10488 0.797536 8.37321 0.750869C8.61071 0.703369 8.70734 0.694261 8.83651 0.685928L8.86987 0.683405C8.87904 0.683405 8.88732 0.68253 8.89648 0.681696C9.33232 0.67003 9.74822 0.709248 10.1332 0.797582C10.4324 0.867582 10.7049 0.967559 11.1991 1.14923L11.3457 1.20342C11.3532 1.20676 11.3616 1.20921 11.3691 1.21254L12.9615 1.87091C13.8765 2.24674 14.3399 3.27174 14.0149 4.20424C13.9416 4.42007 13.8307 4.61674 13.6907 4.78757L14.0257 4.91257C14.9257 5.25341 15.4182 6.19758 15.1732 7.11008C15.0457 7.59591 14.7316 8.0017 14.2891 8.25087C13.8424 8.50254 13.3249 8.56087 12.8315 8.4142L11.0057 7.88173C10.9865 7.8759 10.9674 7.86927 10.9491 7.8626C10.1874 7.55844 8.91735 7.75258 8.11735 8.29424C7.65235 8.60924 7.4165 8.98421 7.4165 9.40671C7.4165 9.80338 7.634 10.1659 8.014 10.4017C8.43316 10.6617 8.9465 10.6984 9.354 10.4967C9.44984 10.4484 9.54821 10.3984 9.64738 10.3484C10.989 9.66503 12.659 8.81423 14.384 9.96173C14.8415 10.2601 15.1324 10.7318 15.1574 11.2201C15.1799 11.6493 14.9948 12.045 14.6382 12.3342C14.6215 12.3475 14.604 12.3601 14.5865 12.3717L12.249 13.8976C11.7465 14.2901 10.7507 14.7693 10.0457 15.0293L10.034 15.0359C9.99568 15.0559 9.95571 15.0717 9.91488 15.0834C9.67654 15.1934 8.74235 15.6717 8.55151 16.4551C8.48235 16.7409 8.22649 16.9326 7.94482 16.9326L7.93905 16.9301ZM10.0065 15.0401C10.0065 15.0401 10.0065 15.0401 10.0057 15.0401C10.0057 15.0401 10.0057 15.0401 10.0065 15.0401Z" fill="url(#paint0_linear_492_9794)"/>
                <defs>
                  <linearGradient id="paint0_linear_492_9794" x1="0.652117" y1="16.9325" x2="16.8101" y2="2.43415" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#182230"/>
                    <stop offset="1" stop-color="#475467"/>
                  </linearGradient>
                </defs>
              </svg>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="high-contrast" title="' . $this->t("High contrast") . '">
              <i class="fa-solid fa-adjust"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="font-size-increase" title="' . $this->t("Increase font size") . '">
              <i class="fa-solid fa-plus"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link action-icon accessibility-tool" href="#" data-action="font-size-decrease" title="' . $this->t("Decrease font size") . '">
              <i class="fa-solid fa-minus"></i>
            </a>
          </li>
        </ul>';

      return [
        '#markup' => $html,
        '#allowed_tags' => ['h3', 'hr', 'ul', 'li', 'a', 'i', 'svg', 'path', 'defs', 'linearGradient', 'stop'],
        '#cache' => [
          'max-age' => 0,
        ],
      ];

    }
    catch (\Exception $e) {
      return [
        '#markup' => '<p>Error loading social media links.</p> ' . $e->getMessage(),
        '#cache' => [
          'max-age' => 0,
        ],
      ];
    }
  }

}
