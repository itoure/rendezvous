<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\UserEvent;
use App\Models\EventMessage;

class Event extends Model {

    protected $guarded = ['eve_id'];
    public $primaryKey = 'eve_id';

    public function location(){
        return $this->belongsTo('App\Models\Location');
    }

    public function getEventsByInterest($interest_id, $event_id, $arrUserLocation) {

        $query = DB::table('events')
            ->join('locations', 'locations.loc_id', '=', 'events.location_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->where('locations.short_country', '=', $arrUserLocation->short_country)
            ->where('interests.int_id', '=', $interest_id)
            ->where('events.eve_id', '<>', $event_id);

        $result = $query->get();
        //dd($result);

        return $result;

    }

    public function getEventsByCountry($arrUserLocation, $exludedEventIds) {

        $query = DB::table('events')
            ->join('locations', 'locations.loc_id', '=', 'events.location_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->whereNotIn('events.eve_id', $exludedEventIds)
            ->where('locations.short_country', '=', $arrUserLocation->short_country);

        $result = $query->get();
        //dd($result);

        return $result;

    }


    public function getUserEventsByInterestsAndLocation($arrUserInterestIds, $arrUserLocation, $exludedEventIds) {

        $query = DB::table('events')
            ->join('locations', 'locations.loc_id', '=', 'events.location_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->whereIn('interest_id', $arrUserInterestIds)
            ->whereNotIn('events.eve_id', $exludedEventIds)
            ->where(function($query) use($arrUserLocation)
            {
                $query->orWhere('locations.short_locality', '=', $arrUserLocation->short_locality)
                    ->orWhere('locations.short_administrative_area_level_2', '=', $arrUserLocation->short_administrative_area_level_2)
                    ->orWhere('locations.short_administrative_area_level_1', '=', $arrUserLocation->short_administrative_area_level_1);
            });

        $result = $query->get();
        //dd($result);

        return $result;

    }


    public function getEventsByUserInterests($arrUserInterestIds, $exludedEventIds) {

        $query = DB::table('events')
            ->join('locations', 'locations.loc_id', '=', 'events.location_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->whereNotIn('events.eve_id', $exludedEventIds)
            ->whereIn('interest_id', $arrUserInterestIds);

        $result = $query->get();
        //dd($result);

        return $result;

    }

    public function getEventsByUserLocation($arrUserLocation, $exludedEventIds) {

        $query = DB::table('events')
            ->join('locations', 'locations.loc_id', '=', 'events.location_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->whereNotIn('events.eve_id', $exludedEventIds)
            ->where(function($query) use($arrUserLocation)
            {
                $query->orWhere('locations.short_locality', '=', $arrUserLocation->short_locality)
                    ->orWhere('locations.short_administrative_area_level_2', '=', $arrUserLocation->short_administrative_area_level_2)
                    ->orWhere('locations.short_administrative_area_level_1', '=', $arrUserLocation->short_administrative_area_level_1);
            });

        $result = $query->get();
        //dd($result);

        return $result;

    }


    public function getParticipantsByEvent($event_id) {

        $query = DB::table('user_events')
            ->join('users', 'users.usr_id', '=', 'user_events.user_id')
            ->where('user_events.event_id', '=', $event_id)
            ->where('user_events.user_event_choice', '=', 'ok');

        $result = $query->get();
        //dd($result);

        return $result;

    }


    public function getAnsweredEventsByUser($user_id) {

        $query = DB::table('user_events')
            ->join('events', 'user_events.event_id', '=', 'events.eve_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->where('user_events.user_id', '=', $user_id);

        $result = $query->get();
        //dd($result->toSql);

        return $result;

    }


    public function getUpcommingEventsByUser($user_id) {

        $query = DB::table('user_events')
            ->join('events', 'user_events.event_id', '=', 'events.eve_id')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->where('user_events.user_id', '=', $user_id)
            ->where('user_events.user_event_choice', '=', 'ok');

        $result = $query->get();
        //dd($result->toSql);

        return $result;

    }


    public function getCompleteEventById($event_id) {
        $query = DB::table('events')
            ->join('users', 'users.usr_id', '=', 'events.user_id')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->leftJoin('user_events', 'user_events.event_id', '=', 'events.eve_id')
            ->where('events.eve_id', '=', $event_id);

        $result = $query->first();
        //dd($result);

        return $result;

    }


    public function countParticipantsByEvent($event_id) {

        $count = UserEvent::where('event_id', '=', $event_id)
            ->where('user_events.user_event_choice', '=', 'ok')
            ->count();
        //dd($count);

        return $count;

    }


    public function getAllMessagesByEvent($event_id) {

        $query = DB::table('event_messages')
            ->join('users', 'users.usr_id', '=', 'event_messages.user_id')
            ->where('event_messages.event_id', '=', $event_id);

        $result = $query->get();
        //dd($result->toSql);

        return $result;
    }

    public function getHostEventByUser($user_id) {

        $query = DB::table('events')
            ->join('interests', 'interests.int_id', '=', 'events.interest_id')
            ->join('categories', 'interests.category_id', '=', 'categories.cat_id')
            ->where('events.user_id', '=', $user_id);

        $result = $query->get();
        //dd($result->toSql);

        return $result;

    }

}
