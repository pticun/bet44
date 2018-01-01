<?php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Page extends Eloquent
{
    protected $pages = [
      'bets'=>[
          'page_content'=>'',
          'browser_title'=>'Past Bets',
          'page_id'=>2
      ],
        'esrewrwer'=>[
            'page_content'=>'',
            'browser_title'=>'Past Bets',
            'page_id'=>2
        ]
    ];

    public function where($slug)
    {
        return $this->bets[$slug] ?? false;
    }
}
