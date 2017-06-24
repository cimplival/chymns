<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Song;

class SongsController extends Controller
{	
	public function index()
	{
    	$songs               = Song::get();

        $no_of_songs         = count($songs);

        $page                = 'cHymns';

    	return view('core.pages.songs.songs', compact('page', 'no_of_songs', 'songs'));
	}
  	
  	public function search(Request $request)
  	{
  		$this->validate($request, [
          'search'              => 'required|min:1'
        ],
        [
          'search.required'     => 'You need to search a song.',
        ]);

    	$query                  = $request->input('search');

        $songs = Song::where('search', 'LIKE', '%' . $query . '%')
        	->orwhere('lyrics', 'LIKE', '%' . $query . '%')
            ->orwhere('search_lyrics', 'LIKE', '%' . $query . '%')
            ->orWhere('search_title', 'LIKE', '%' . $query . '%')
            ->get();

        if(count($songs)==1)
        {
            $tense              = 'is';
            $result             = 'result.';
        }
        else
        {
            $tense              = 'are';
            $result             = 'results.';
        }

        $message                = 'There '. $tense . ' ' . count($songs) . ' song '. $result;

        $page                   = 'cHymns';

        $no_of_songs            = count($songs);


        return view('core.pages.songs.songs', compact('songs', 'page', 'no_of_songs'))->with('success', 'success');
  	}

  	public function show($id)
  	{	
  		$song                       = Song::where('id', $id)->first();

  		$page                       = $song->title;

  		$song = new \SimpleXMLElement($song->lyrics);

  		$song = $song->asXML();

  		$general = $song;



  		// start chorus parsing

      $choruses = array();

      $no_of_chorus = substr_count($song, 'type="c">');

        for($i=1; $i<=$no_of_chorus; $i++)
        {
            $start_chorus = '<verse label="'. $i .'" type="c"><![CDATA[';

            $end_chorus = ']]';

            $song = " ".$song;

            $ini = strpos($song,$start_chorus);

            if ($ini == 0) return "";

            $ini += strlen($start_chorus); 

            $len = strpos($song,$end_chorus,$ini) - $ini;

            $final_chorus = substr($song,$ini,$len);

            $choruses[] = $final_chorus;
        }


  		//start verse parsing

      $stanzas = array();

      $no_of_verses = substr_count($song, 'type="v">');

        for($i=1; $i<=$no_of_verses; $i++)
        {
            $start_verse = '<verse label="'. $i .'" type="v"><![CDATA[';

            $end_verse = ']]';

            $song = " ".$song;

            $ini = strpos($song,$start_verse);

            if ($ini == 0) return "";

            $ini += strlen($start_verse); 

            $len = strpos($song,$end_verse,$ini) - $ini;

            $final_verses = substr($song,$ini,$len);

            //if no period at the end add period
            if ($final_verses[strlen($final_verses) - 1] != '.') 
            {
              $final_verses . '.';
            }

            $stanzas[] = $final_verses;

        }

        return view('core.pages.song.index', compact('page', 'choruses', 'stanzas'));
  	}
}
