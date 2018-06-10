<?php
namespace Acme\Controllers;

use Acme\Interfaces\ControllerInterface;
use duncan3dc\Laravel\BladeInstance;
use Goutte\Client;
use Kunststube\CSRFP\SignatureGenerator;
use Acme\Http\Response;
use Acme\Http\Request;
use Acme\Http\Session;

/**
 * Class BaseController
 * @package Acme\Controllers
 */
class BaseController implements ControllerInterface {

    protected $blade;
    protected $signer;
    public $response;
    public $request;
    public $session;
    public $crawler;
    public $js_files=['/bower_components/jquery/dist/jquery.js'];
    public $js_footer_files=[];
    public $css_files=[];
    public $refresh_session = false;

    /**
     * @param string $type
     */
    public function __construct(Request $request, Response $response,
                                Session $session, SignatureGenerator $signer,
                                BladeInstance $blade, Client $crawler, $type='text/html')
    {
        $this->signer = $signer;
        $this->blade = $blade;
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->crawler = $crawler;

//        if(!isset($_SESSION['LAST_ACTIVITY']) || hasSessionTimedout()){
//            $this->refresh_session = true;
//        }
    }

}
