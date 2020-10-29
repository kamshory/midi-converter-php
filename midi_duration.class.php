<?php
require('midi.class.php');

/**
 * Class MidiDuration
 *
 * Last changes:
 * 2010-08-09 improved getDuration, now also handles tempo changes
 *
 * @author Valentin Schmidt
 * @version 0.2
 */
 
class MidiDuration extends Midi{
	
/**
 * returns duration in seconds
 *
 * @access public
 * @return int duration
 */
function getDuration(){
	$duration = 0;
	$currentTempo = 0;
	$t = 0;
	
	$track = $this->tracks[0];
	
	
	$f = 1 / $this->getTimebase() / 1000000;
	
	foreach($this->tracks as $trk)
	{
		$mc = count($trk);
		for ($i=0;$i<$mc;$i++){
			$msg = explode(' ',$trk[$i]);
			if (@$msg[1]=='Tempo'){
				$dt = (int)$msg[0] - $t;
				$duration += $dt * $currentTempo * $f;
				$t = (int)$msg[0];
				$currentTempo = (int)$msg[2];
			}
		}
	}
	# find last event in all tracks
	$end_time = $t;
	foreach ($this->tracks as $track){
		$msg = explode(' ', $track[count($track)-1]);
		$end_time = max($end_time, (int)$msg[0]);
	}
	if ($end_time>$t){
		$dt = $end_time - $t;
		$duration += $dt * $currentTempo * $f;
	}
	return $duration;
}

/**
 *
 * @access public
 * @return int tempo
 */
function getTempo(){
	return $this->tempo;
}

} //END CLASS
	
?>