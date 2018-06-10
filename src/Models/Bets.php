<?php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Acme\Betting\Arbitrage;
use Goutte\Client;

class Bets extends Eloquent
{

    public function get()
    {
        $refresh_session = false;

        if(!isset($_SESSION['LAST_ACTIVITY']) || hasSessionTimedout()){
            $refresh_session = true;
        }
        $client = new Client();
        $results = [];
        foreach (SITES as $site) {
//            $class = __NAMESPACE__ . '\\' . $site;

            if($refresh_session){
                $possible_games = possible_games(NAMES[$site]);
                foreach ($possible_games as $possible_game) {
                    $standardised_team_names = $possible_game['standardised_team_names'];
                    $site_team_names = $possible_game['site_team_names'];
                    if($site::eventExists($site_team_names[0], $site_team_names[1], $client)){
                        $_SESSION['active_events'][$site][] = $standardised_team_names[0].'_v_'.$standardised_team_names[1];
                    }
                };
            }
//            if($refresh){
//                $_SESSION['active_events'] = [];
//                $_SESSION['active_events'][$site] = [];
//                $possible_games = possible_games(NAMES[$site]);
//                foreach ($possible_games as $possible_game) {
//                    $standardised_team_names = $possible_game['standardised_team_names'];
//                    $site_team_names = $possible_game['site_team_names'];
//                    if($site::eventExists($site_team_names[0], $site_team_names[1])){
//                        $_SESSION['active_events'][$site][] = $standardised_team_names[0].'_v_'.$standardised_team_names[1];
//                    }
//                }
//            }
//            foreach ($_SERVER['active_events'][$site] as $match){
//
//                $slug = $site::urlSlugFormatter($match[0], $match[1]);
//
//                $oddschecker = new Oddschecker('https://www.oddschecker.com/football/english/premier-league/'.$slug.'/winner', $client);
//                    $oddschecker->exec();
//                    $results['data'] = $oddschecker->getResults();
//            }

        }

        $results = array_merge($results, [
            'page_content'=>'',
            'browser_title'=>'Bets',
            'page_id'=>3
        ]);

        return $results;
    }
}
