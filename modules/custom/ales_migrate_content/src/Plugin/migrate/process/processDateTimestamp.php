<?php
namespace Drupal\ales_migrate_content\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Transform date time to timestamp.
 *
 * @MigrateProcessPlugin(
 *   id = "date_time_to_timestamp_ales"
 * )
 */
class DateTimeToTimestamp extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    return strtotime($value);
  }

}