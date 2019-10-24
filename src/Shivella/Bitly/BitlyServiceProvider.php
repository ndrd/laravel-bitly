<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Shivella\Bitly;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Shivella\Bitly\Client\BitlyClient;

/**
 * Class BitlyServiceProvider
 */
class BitlyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('bitly', function () {
            return new BitlyClient(new Client(), config('bitly.accesstoken', ''));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
          // Config file path.
          $dist = __DIR__.'/../../config/bitly.php';

          // If we're installing in to a Lumen project, config_path
          // won't exist so we can't auto-publish the config
          if (function_exists('config_path')) {
              // Publishes config File.
              $this->publishes([
                  $dist => config_path('bitly.php'),
              ]);
          }
  
          // Merge config.
          $this->mergeConfigFrom($dist, 'bitly');
    }
}
