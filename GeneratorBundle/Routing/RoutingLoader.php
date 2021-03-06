<?php

namespace Admingenerator\GeneratorBundle\Routing;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class RoutingLoader extends FileLoader
{
    // Assoc beetween a controller and is route path 
    //@todo make an object for this
    protected $actions = array(
        'list' => array(
                    'pattern'      => '/',
                    'defaults'     => array(),
                    'requirements' => array(),
                ),
        'delete' => array(
                    'pattern'      => '/{id}/delete',
                    'defaults'     => array(),
                    'requirements' => array(),
                ),
        'edit' => array(
                    'pattern'      => '/{id}/edit',
                    'defaults'     => array(),
                    'requirements' => array(),
                ),  
        'update' => array(
                    'pattern'      => '/{id}/update',
                    'defaults'     => array(),
                    'requirements' => array(),
                    'controller'   => 'edit',
                ),
        'new' => array(
                    'pattern'      => '/new',
                    'defaults'     => array(),
                    'requirements' => array(),
                ),  
        'create' => array(
                    'pattern'      => '/create',
                    'defaults'     => array(),
                    'requirements' => array(),
                    'controller'   => 'new',
                ),
    );
    
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();
        
        $namespace = $this->getNamespaceFromResource($resource);
        $bundle_name = $this->getBundleNameFromResource($resource);
        
        foreach ($this->actions as $controller => $datas) {

            $action = 'index';
            $route_name = $bundle_name.'_'.$controller;
                        
            if(isset($datas['controller'])) {
                $action     = $controller;
                $controller = $datas['controller'];
            }
            
            $datas['defaults']['_controller'] = $namespace.$bundle_name.':'.ucfirst($controller).':'.$action; 
            
            $route = new Route($datas['pattern'],$datas['defaults'], $datas['requirements']);
            $collection->add($route_name, $route);
            $collection->addResource(new FileResource($resource.ucfirst($controller).'Controller.php'));
        }

        return $collection;
    }
    
    public function supports($resource, $type = null)
    {
        return 'admingenerator' == $type;
    }
    
    protected function getBundleNameFromResource($resource)
    {
        preg_match('#.+/(.+Bundle)/Controller?/$#', $resource, $matches);
        
        return $matches[1];
    }
    
    protected function getNamespaceFromResource($resource)
    {
        preg_match('#.+/(.+)/(.+Bundle)/Controller?/$#', $resource, $matches);

        return $matches[1];
    }
}