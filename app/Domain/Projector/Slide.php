<?php namespace Zeropingheroes\Lanager\Domain\Projector;

use Zeropingheroes\Lanager\Domain\BaseModel;
use ExpressiveDate;

class Slide extends BaseModel {

	protected $fillable = [ 'parent_id', 'title', 'url', 'content', 'position', 'published', 'timespan', 'startdate', 'enddate', 'starttime', 'endtime' ];

	protected $nullable = [ 'url', 'content', 'position', 'startdate','enddate', 'starttime', 'endtime' ];

	protected $optional = [ 'published', 'timespan' ];

	public function activeSummary()
  {
    $start = new ExpressiveDate;
      if ( $this->startdate != null) {
        $start = ExpressiveDate::make($this->startdate);
 			// if timespan start falls on the hour, dont display minutes
      if ( $start->getMinute() == 0)
 			{
				$startFormat = 'l ga';
 			}
			else
			{
 				$startFormat = 'l g:ia';
 			}
		}

    $end = new ExpressiveDate;
 		if ( $this->enddate != null) {
      $end = ExpressiveDate::make($this->enddate);
			// if timespan start falls on the hour, dont display minutes
			if ( $end->getMinute() == 0)
			{
				$endFormat = 'ga';
			}
			else
			{
				$endFormat = 'g:ia';
			}

			// if timespan does not start and end on the same day, display the end day
			if ( $this->startdate==null || $start->getDay() != $end->getDay() )
			{
				$endFormat = 'l '.$endFormat;
			}
		}

		if ($this->startdate == null) {
			return "until ".$end->format($endFormat);
		} else if ($this->enddate == null) {
			return "from ".$start->format($startFormat);
    } else if ($this->startdate != null && $this->enddate != null) {
      return $start->format($startFormat).' to '. $end->format($endFormat);
    } else {
      return "Always";
		}
	}

	public function isActive() {
		if (($this->startdate == null) && ($this->enddate == null))
			//slide isn't date controlled
			return $this->published;
		if (($this->startdate == null || $this->startdate <= date('Y-m-d H:i:s')) && ($this->enddate == null || $this->enddate >= date('Y-m-d H:i:s')))
			//slide is live
			return $this->published;
		else
			return 0;
		
	}

}
