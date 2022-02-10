<?php

namespace Drupal\dam_client\Plugin\media\Source;

use Drupal\Component\Serialization\Json;
use Drupal\media\MediaInterface;
use Drupal\media\MediaSourceBase;

/**
 * External image entity media source.
 *
 * @see \Drupal\file\FileInterface
 *
 * @MediaSource(
 *   id = "dam_source",
 *   label = @Translation("DAM Source"),
 *   description = @Translation("Use remote images from the DAM."),
 *   allowed_field_types = {"text_long"},
 *   thumbnail_alt_metadata_attribute = "alt",
 *   default_thumbnail_filename = "no-thumbnail.png"
 * )
 */
class DamSource extends MediaSourceBase {

  /**
   * {@inheritDoc}
   */
  public function getMetadataAttributes() {
    return [
      'id' => $this->t('ID'),
      'title' => $this->t('Title'),
      'alt_text' => $this->t('Alternative text'),
      'caption' => $this->t('Caption'),
      'copyright' => $this->t('Copyright'),
      'uri' => $this->t('URL'),
      'width' => $this->t('Width'),
      'height' => $this->t('Height'),
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function getMetadata(MediaInterface $media, $attribute_name) {
    $remote_field = $media->get($this->configuration['source_field']);
    $json_arr = Json::decode($remote_field->value);
    if (!$remote_field) {
      return parent::getMetadata($media, $attribute_name);
    }
    switch ($attribute_name) {
      case 'default_name':
        return $json_arr->alt_text;
      case 'thumbnail_uri':
        return $json_arr->uri;
      default:
        return $json_arr->$attribute_name ?? parent::getMetadata($media, $attribute_name);
    }
  }

}
