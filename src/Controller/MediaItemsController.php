<?php

namespace Drupal\dam_client\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\dam_client\Api\DamApiInterface;

/**
 * Define a controller that shows remote media items from [branding] DAM.
 */
class MediaItemsController extends ControllerBase {

  /**
   * The [branding] DAM API service.
   *
   * @var \Drupal\dam_client\Api\DamApiInterface
   */
  protected DamApiInterface $damApi;

  /**
   * Construct a new media items controller.
   *
   * @param \Drupal\dam_client\Api\DamApiInterface $dam_api
   *   The [branding] DAM API service.
   */
  public function __construct(DamApiInterface $dam_api) {
    $this->damApi = $dam_api;
  }

  /**
   * Returns a list of media items to select in a media widget.
   *
   * @return array
   *   The media item render array.
   *
   * @throws \Drupal\api_connection\RestApiEnvironmentUrlException
   */
  public function getMediaItems(): array {
    $items = $this->damApi->getMediaItems()->getBody();
    $items = Json::decode((string) $items);

    return [
      '#theme' => '[branding]_dam_media_items',
      '#items' => $items,
      '#empty' => count($items) === 0,
      '#empty_text' => $this->t('No media items were found.'),
    ];
  }

}
