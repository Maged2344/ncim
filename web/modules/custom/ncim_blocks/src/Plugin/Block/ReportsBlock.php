<?php

namespace Drupal\ncim_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;

/**
 * Provides a Reports Block.
 *
 * @Block(
 *   id = "reports_block",
 *   admin_label = @Translation("Reports Block"),
 *   category = @Translation("NCIM Blocks")
 * )
 */
class ReportsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * Constructs a new ReportsBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, FileUrlGeneratorInterface $file_url_generator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('file_url_generator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = [];
    $reports = $this->loadAnnualReports();
    
    if ($reports) {
      $content['reports'] = $this->buildReportsContent($reports);
    }
    
    if (empty($content)) {
      return [
        '#markup' => '<p>' . $this->t('No annual reports found.') . '</p>',
      ];
    }

    return [
      '#theme' => 'reports_content',
      '#content' => $content,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Load annual reports.
   *
   * @return array
   *   Array of report nodes.
   */
  protected function loadAnnualReports() {
    $current_language = \Drupal::languageManager()->getCurrentLanguage();
    $language_id = $current_language->getId();
    
    // First try to load reports in current language
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'annual_report')
      ->condition('status', 1)
      ->condition('langcode', $language_id)
      ->condition('field_is_active', 1)
      ->sort('field_display_order', 'ASC')
      ->sort('field_year', 'DESC')
      ->accessCheck(FALSE);

    $nids = $query->execute();
    
    // If no reports found in current language, try to load any available reports
    if (empty($nids)) {
      $fallback_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'annual_report')
        ->condition('status', 1)
        ->condition('field_is_active', 1)
        ->sort('field_display_order', 'ASC')
        ->sort('field_year', 'DESC')
        ->accessCheck(FALSE);
      
      $nids = $fallback_query->execute();
    }
    
    if (empty($nids)) {
      return [];
    }

    return $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
  }

  /**
   * Build reports content for template.
   *
   * @param array $reports
   *   Array of report nodes.
   *
   * @return array
   *   Formatted reports data.
   */
  protected function buildReportsContent($reports) {
    $formatted_reports = [];
    
    foreach ($reports as $report) {
      $file_url = '';
      $file_size = '';
      
      if ($report->hasField('field_report_file') && !$report->get('field_report_file')->isEmpty()) {
        $file = $report->get('field_report_file')->entity;
        if ($file) {
          $file_url = $this->fileUrlGenerator->generateAbsoluteString($file->getFileUri());
          $file_size = $this->formatFileSize($file->getSize());
        }
      }
      
      $formatted_reports[] = [
        'title' => $report->getTitle(),
        'year' => $report->get('field_year')->value,
        'type' => $report->get('field_report_type')->value,
        'file_url' => $file_url,
        'file_size' => $file_size,
        'download_text' => $this->t('تنزيل'),
        'display_order' => $report->get('field_display_order')->value ?? 0,
      ];
    }
    
    return $formatted_reports;
  }

  /**
   * Format file size in human readable format.
   *
   * @param int $bytes
   *   File size in bytes.
   *
   * @return string
   *   Formatted file size.
   */
  protected function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
      return number_format($bytes / 1073741824, 1) . ' GB';
    }
    elseif ($bytes >= 1048576) {
      return number_format($bytes / 1048576, 1) . ' MB';
    }
    elseif ($bytes >= 1024) {
      return number_format($bytes / 1024, 1) . ' KB';
    }
    else {
      return $bytes . ' bytes';
    }
  }

}
