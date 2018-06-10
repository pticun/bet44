<?php

namespace Acme\Controllers;

use Acme\Betting\Arbitrage;
use Acme\Http\Request;
use Acme\Models\Oddschecker;
use Goutte\Client;
use Acme\Models;

/**
 * Class PageController
 * @package Acme\Controllers
 */
class PageController extends BaseController
{
    public $page;

    /**
     * Show the home page
     * @return html
     */
    public function getShowHomePage()
    {
    }

    public function bets()
    {
        $this->js_files[] = APP_JS_PATH.'tablesorter/js/jquery.tablesorter.js';
//        $this->js_footer_files[] = APP_JS_PATH.'bets.js';
        $css_files[] = APP_JS_PATH.'tablesorter/css/theme.default.css';
        $css_files[] = "https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css";

//        $target = $this->getUri();
        // find matching page in the db
        $this->refresh_session = true;
        if($this->refresh_session){
            $odds = [];
            $arbs = [];
            foreach (COMPETITIONS as $website_key => $website_details) {
                if(!array_key_exists($website_key, $odds)){
                    $odds[$website_key] = [];
                }
                foreach ($website_details['sports'] as $sport_key => $sport_competitions) {
                    if(!array_key_exists( $sport_key, $odds[$website_key])){
                        $odds[$website_key][$sport_key] = [];
                    }
                    foreach ($sport_competitions as $competition) {
                        $test = [];
                        $class_name = 'Acme\Models\\' . $website_key . '\\' . $sport_key . '\\' . $competition;
                        $model = new $class_name($this->crawler, $website_details['url']);
                        foreach (TEAMS[$website_key][$competition]['teams'] as $team_key => $team_name) {
                            foreach (TEAMS[$website_key][$competition]['teams'] as $k => $v) {
                                if(!array_key_exists( $competition, $odds[$website_key][$sport_key])){
                                    $odds[$website_key][$sport_key][$competition] = [];
                                }
                                if ($team_name !== $v) {
//                                    echo $k."<br />";
                                    $model->setCrawler($this->crawler, sprintf(TEAMS[$website_key][$competition]['slug_format'], $team_name, $v));
                                    $match_data = $model->getOdds();
                                    //echo '<pre>';print_r($match_data);
                                    $bookmakers = $model->getBookmakers();
                                    $even_date = $model->getEventDate();//dd($even_date);

                                    if(!empty($match_data)){
                                        $match_odds = $model->sortRows($match_data, $bookmakers);
                                        $arbInstance = new Models\Arbs();
                                        $match_arbs = $arbInstance->get($match_odds);
                                        $sorted_rows = ['teams'=>[$team_name, $v], 'odds'=>$match_odds];
                                        $sorted_arbs = ['teams'=>[$team_name, $v], 'arbs'=>$match_arbs];
                                        if(!empty($sorted_rows)){ //echo '<pre>';print_r($sorted_rows);
                                            $odds[$website_key][$sport_key][$competition][] = $sorted_rows;
                                        }
                                        if(!empty($sorted_arbs)){ //echo '<pre>';print_r($sorted_rows);
                                            $arbs[$website_key][$sport_key][$competition][] = $sorted_arbs;
                                        }
                                    }
                                }

                            }
                        }
                    }
                }//pp($arbs); pp($odds, true);
            }
        }

//        $arbs = new Models\Arbs(); //echo '<pre>'; print_r($data['data']['odds']);die;
//        $arb_opportunities = $arbs->get($data['data']['odds']);
//        echo '<pre>'; print_r($arb_opportunities);die;
//
//        if (!isset($data['browser_title'])) {
//            $this->getShow404();
//            return true;
//        }

//        echo '<pre>';

        return $this->response
            ->with('browser_title', 'Arb Page')
//            ->with('page_content', $data['page_content'])
//            ->with('page_id', $data['page_id'])
//            ->with('js_footer_files', $this->js_footer_files)
//            ->with('js_files', $this->js_files)
            ->with('css_files', $css_files)
            ->with('odds', $odds ?? null)
            ->with('arbs', $arbs ?? null)
//            ->with('bookmakers', $data['data']['bookmakers'] ?? null)
            ->withView('bets')
            ->render();
    }

    /**
     * Show a generic page from db
     * @return html
     */
    public function getShowPage()
    {
        // extract page name from the url
        $target = $this->getUri();
        $data = [];
        // find matching page in the db
        $page = new Models\Page();
        $this->page = $page->where($target);
        // look up page content
        if ($this->page) {
            $data['browser_title'] = $this->page['browser_title'];
            $data['page_content'] = $this->page['page_content'];
            $data['page_id'] = $this->page['page_id'];
        }

        $this->render($target, $data);

    }

    public function render($target, $data=null)
    {
        if (!isset($data['browser_title'])) {
            $this->getShow404();
            return true;
        }

        return $this->response
            ->with('browser_title', $data['browser_title'])
            ->with('page_content', $data['page_content'])
            ->with('page_id', $data['page_id'])
            ->withView($target)
            ->render();
    }

    /**
     * show 404 page
     */
    public function getShow404()
    {
        return $this->response
            ->withView('page-not-found')
            ->withError("Page not found!")
            ->withResponseCode(404)
            ->render();
    }

    /**
     * @param $stringToSlug
     * @param string $separator
     * @return mixed|string
     */
    public function makeSlug($stringToSlug, $separator = "-")
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $stringToSlug);
        $slug = preg_replace("%[^-/+|\w ]%", '', $slug);
        $slug = strtolower(trim($slug));
        $slug = preg_replace("/[\/_|+ -]+/", $separator, $slug);
        return $slug;
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        $uri = explode("/", $this->request->server['REQUEST_URI']);
        return $uri[1];
    }
}