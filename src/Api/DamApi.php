<?php

namespace Drupal\dam_client\Api;

use Drupal\api_connection\Plugin\RestApiConnectionInterface;
use Drupal\api_connection\Plugin\RestApiConnectionManagerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Defines the [branding] DAM api functionality.
 */
class DamApi implements DamApiInterface {

  /**
   * The API connection service.
   *
   * @var \Drupal\api_connection\Plugin\RestApiConnectionInterface
   */
  protected RestApiConnectionInterface $apiConnection;

  /**
   * Constructs a new DamApi object.
   *
   * @param \Drupal\api_connection\Plugin\RestApiConnectionManagerInterface $rest_api_connection_manager
   *   The rest API connection plugin manager.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function __construct(RestApiConnectionManagerInterface $rest_api_connection_manager) {
    $this->apiConnection = $rest_api_connection_manager->createInstance('[branding]_dam_api_connection');
  }

  /**
   * Authorize requests.
   */
  protected function authorize() {

  }

  /**
   * {@inheritDoc}
   */
  public function getMediaItems(string $type = 'image', array $sorting = [], int $offset = 0, int $limit = 50): ResponseInterface {
    $query = [];

    // Add offset to query.
    $query['page[offset]'] = $offset;
    // Add limit to query.
    $query['page[limit]'] = $limit;

    // Use shorthand method for sorting in query, e.g:
    //   sort=created,-uid.name
    if (count($sorting) > 0) {
      $query['sort'] = '';
      foreach ($sorting as $sort_field => $sort_direction) {
        if ($query['sort'] !== '') {
          $query['sort'] .= ',';
        }
        switch ($sort_direction) {
          case 'DESC':
            $query['sort'] .= '-' . $sort_field;
            break;
          case 'ASC':
          default:
            $query['sort'] .= $sort_field;
            break;
        }
      }
    }

    // Build up the query string.
    $query_string = http_build_query($query, '?');
    return $this->apiConnection->sendRequest('jsonapi/media/' . $type . '?' . $query_string, 'GET');
  }

}
