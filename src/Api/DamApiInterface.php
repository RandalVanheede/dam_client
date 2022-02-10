<?php

namespace Drupal\dam_client\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * Defines the required functionality a [branding] DAM api object should have.
 */
interface DamApiInterface {

  /**
   * Returns all media items.
   *
   * @param string $type
   *   The media bundle type on the DAM itself (Not on this drupal instance!).
   * @param array $sorting
   *   The sorting, this can be formatted as such:
   *     array('created' => 'ASC', 'uid.name' => 'DESC')
   * @param int $offset
   *   The offset, defaults to 0.
   * @param int $limit
   *   The limit, defaults to 50.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   The API response.
   *
   * @throws \Drupal\api_connection\RestApiEnvironmentUrlException
   */
  public function getMediaItems(string $type = 'image', array $sorting = [], int $offset = 0, int $limit = 50): ResponseInterface;

}
