<?php
require('midi.class.php');

class MidiLyric extends Midi{
	public function getLyric()
	{
		$midi = $this;
		$lyric = new StdClass();
		$lyric->tracks = array();
		$j = 0;
		foreach($midi->tracks as $i=>$track)
		{
			$lyric->tracks[$i] = array();
			foreach($track as $j=>$raw)
			{
				$arr = explode(' ', $raw, 3);
				$time = $arr[0];
				$type = $arr[1];
				$data = $arr[2];
				if($type == 'Meta' && stripos($data, 'Lyric ') === 0)
				{
					$lyric->tracks[$i][$j] = $raw;
				}
			}
		}
		return $lyric;
	}
}

?>