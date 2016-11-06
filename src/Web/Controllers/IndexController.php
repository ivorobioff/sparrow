<?php
namespace ImmediateSolutions\Web\Controllers;
use ImmediateSolutions\Web\Support\Controller;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class IndexController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->show('index');
    }

    /**
     * @return ResponseInterface
     */
    public function api()
    {
        return $this->show('api');
    }

}