<?php
/**
 * Yii2 php swagger module
 *
 * @author    Simon Rodin <master@genx.ru>
 * @license   http://opensource.org/licenses/MIT MIT Public
 * @link      https://github.com/yjballestero/yii2-oas3
 *
 */

namespace yjballestero\swagger;

use Yii;
use yii\base\Action;
use yii\web\Response;
use Symfony\Component\Finder\Finder;

class JsonAction extends Action
{
    /**
     * @var string|array|Finder directory(s) or filename(s) with open api annotations.
     */
    public Finder|string|array $dirs;

    /**
     * @var array
     *   exclude: string|array $exclude The directory(s) or filename(s) to exclude (as absolute or relative paths)
     *   analyser: defaults to StaticAnalyser
     *   analysis: defaults to a new Analysis
     *   processors: defaults to the registered processors in Analysis
     */
    public array $scanOptions = [];

    /**
     * @return \OpenApi\Annotations\OpenApi|null
     */
    public function run(): ?\OpenApi\Annotations\OpenApi {
        $this->initCors();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return \OpenApi\Generator::scan($this->dirs, $this->scanOptions);
    }

    /**
     * Init cors.
     * @return void
     */
    protected function initCors(): void {
        $headers = Yii::$app->getResponse()->getHeaders();

        $headers->set('Access-Control-Allow-Headers', 'Content-Type');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT');
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Allow', 'OPTIONS,HEAD,GET');
    }
}
