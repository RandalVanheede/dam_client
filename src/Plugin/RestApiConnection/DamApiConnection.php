<?php

namespace Drupal\dam_client\Api;

use Drupal\api_connection\Plugin\RestApiConnectionBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Defines the API functionality for [branding] DAM.
 *
 * @RestApiConnection(
 *   id = "req_res",
 *   label = @Translation("REQ|RES API"),
 *   urls = {
 *     "dev" = "https://reqres.in",
 *     "test" = "https://reqres.in",
 *     "live" = "https://reqres.in"
 *   }
 * )
 */
class DamApiConnection extends RestApiConnectionBase {

  /**
   * The immutable DAM config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected ImmutableConfig $damConfig;

  /**
   * {@inheritDoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelFactoryInterface $logger_factory, ConfigFactoryInterface $config_factory, ClientFactory $client_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $logger_factory, $config_factory, $client_factory);

    $this->damConfig = $config_factory->get('dam_client.settings');

    // Override the default config.
    $this->setConfiguration(array_merge($this->getConfiguration(), [
      'urls' => $this->getDamConfig()->get('urls'),
    ]));
  }

  /**
   * Returns the [branding] DAM specific config.
   *
   * @return \Drupal\Core\Config\ImmutableConfig
   */
  public function getDamConfig(): ImmutableConfig {
    return $this->damConfig;
  }

}
