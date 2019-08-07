<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mf\Emailer\View\Resolver;

/*use Countable;
use IteratorAggregate;
use Zend\Stdlib\PriorityQueue;
use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\ResolverInterface as Resolver;*/

use Zend\View\Resolver\AggregateResolver;
use Zend\View\Renderer\RendererInterface as Renderer;

class DbResolver extends AggregateResolver
{
    const FAILURE_NO_RESOLVERS = 'AggregateResolver_Failure_No_Resolvers';
    const FAILURE_NOT_FOUND    = 'AggregateResolver_Failure_Not_Found';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Resolve a template/pattern name to a resource the renderer can consume
     *
     * @param  string $name
     * @param  null|Renderer $renderer
     * @return false|string
     */
    public function resolve($name, Renderer $renderer = null)
    {
        $this->lastLookupFailure      = false;
        $this->lastSuccessfulResolver = null;

        if (0 === count($this->queue)) {
            $this->lastLookupFailure = static::FAILURE_NO_RESOLVERS;
            return false;
        }

        foreach ($this->queue as $resolver) {
            $resource = $resolver->resolve($name, $renderer);
            if ($resource) {
                // Resource found; return it
                $this->lastSuccessfulResolver = $resolver;
                return $resource;
            }
        }

        $this->lastLookupFailure = static::FAILURE_NOT_FOUND;
        return false;
    }

}
