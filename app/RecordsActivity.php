<?php


namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity(){

        if(auth()->guest()) return;
        foreach (static::getRecordEvents() as $event){
            static::$event(function ($model) use ($event){
                $model->recordActivity($event);
            });
        }

       static::deleting(function($model){
          $model->activity()->delete();
       });
    }

    protected static function getRecordEvents(){
        //dd("record event");
        return ["created"];
    }

    protected function getActivityType($event)
    {
        $type=strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
     //  return $event . "_" . $type;
    }

    protected function recordActivity($event)
    {

        $this->activity()->create([
            "type" => $this->getActivityType($event),
            "user_id" => auth()->id()
        ]);
//        Activity::create([
//            "type" => $this->getActivityType($event),
//            "user_id" => auth()->id(),
//            "subject_id" => $this->id,
//            "subject_type" => get_class($this)
//        ]);
    }

    public function activity(){
        return $this->morphMany('App\Activity','subject');
    }
}