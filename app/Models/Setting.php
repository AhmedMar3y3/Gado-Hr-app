<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];
}
/*
I want you to make the attendance functionality and of course make the code clean and use a service class to handle the attendance logic first I have employees table and I'll provide it each employee has a shift for example employee Ahmed who has a shift from 9 to 5 when he arrives to the place of work he sends the request to save his attendence time of course with the other things but mainly the attendance time but to get that we need to make sure of some stuff first whether he is close to the office or not and the distance is configured as a key called distance with it's value in the table settings so we need to use this distance to confirm that the current distance between the employee and the office is equal to the specified distance of less than it if it's less or equal save the attendance if not return error that he needs to be closer to the place and of course the employee will provide the long and lat of himself as params and the long and lat of the office are already attached to the employee because each employee has a location_id which is a table has the offices whith its' longs and lats so calc the distance between the current user location and the office he is related to location and if it's less than or equal to the specified distance in the settings that is correct that's the first step then save the attendance time and use the shift of the user to know whether he attended in the time, late or early and calculate the number of minutes he is late with and save it to the column total_delay and when the employee sends another request then thats the departure also make the same thing check whther he is close to the place or not and then save the time of departure and if he left earier than he should be regarding his shift add this time to his total_delay like if his shift is from 09:00 to 17:00 and he arrived 09:20 and left 16:50 then the total delay is 30 minutes,now to the columns of the table first the date should be saved automatically with the date of the day then the attendance and departure as I told you those are the check_in and out times then the status which is enum you should save between 0 ,1 , 2 and this depends on the time he arrives at if earlier than the his shift begins should be the first enum value and if earlier the second and if later then the third then we have the total_delay as I told you about and last the overtime this if the employee departed from the office after the shift ends then calculate the difference between the shift end and the time he left and save it to the overtime column and when he arrives earlier than his shift time also add this to his overtime so we have 2 cases for the over time and 2 cases for the delay that's all now here is your refrences:
*/