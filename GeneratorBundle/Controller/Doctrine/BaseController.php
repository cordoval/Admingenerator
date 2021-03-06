<?php

namespace Admingenerator\GeneratorBundle\Controller\Doctrine;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * A base controller for Doctrine
 *
 * @author cedric Lombardot
 *
 */
abstract class BaseController extends Controller
{
    protected function getEntityManager()
    {
        $this->getDoctrine()->getEntityManager();
    }
}