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
I want now to add the salary functionality to the attendance system.
The salary is calculated based on the attendance of the employee.
The salary is calculated as follows:
- The employee has a base salary per month which is saved in the employees table.
- The employee has a daily salary which is calculated as the base salary divided by the number of days in the month so if the base salary is 3000 and the month has 30 days then the daily salary is 100 and ofcouse the daily salary can change based on the month.
- there are holidays in the month and the employee should not be deducted for these days when he is absent also there is weekends like friday if the employee is not working on friday then he should be paid for this day.
- The employee can have a deduction from his daily_salary based on the attendance if he is total_delay in the attendance is equal to or more than 40 minutes then he should be deducted with the value of deduction in the settings.
- The employee can have a bonus in his salary depending on the daily report if the report addition = 2 which is the value of the overtime in the enum and the report is confirmed (if it's not add a case in the function of confirm report to add the bonus) add the bonus to the daily salary which is taken from the settings using a key called bonus.
- The employee can have a bonus in his salary depending on the daily report if the report addition = 1 which is the value of the target in the enum and the report is confirmed (if it's not add a case in the function of confirm report to add the bonus) add the target bonus to the daily salary and the target bonus is taken from the settings also key = target.
*/