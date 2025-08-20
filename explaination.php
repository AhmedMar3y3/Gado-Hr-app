<?php

/*
we have a feature for the attendance and departure of the employees and managers

- first each employee has a job with job_id and each job has a type here are the types
    case DRIVER = 'driver';
    case SALES = 'sales';
    case TECHNICIAN = 'technician';
    case OTHER = 'other';

- now for the attendance and departure the employee also has a location id that is attached to and the location has the option to be remote so the employee can clock in and out from anywhere if the location is remote if not he must clock in and out within the specified location or around it with a disstance that is allowed from the settings and already handled
- so the attendance is working fine I think but there are updates on the departure the employee must add a report before the departure and each employee has a different form of the report based on the job he has "job type said earlier" let's talk about each one
1. first case driver if the employee's job has a type of DRIVER he must fill a report that includes the following fields ---> "num_of_devices,overtime_hours"
2. second case sales if the employee's job has a type of SALES he must fill a report that includes the following fields ---> "sold_devices,bought_devices,commercial_devices"
3. third case technician if the employee's job has a type of TECHNICIAN he must fill a report that includes the following fields ---> "num_of_devices,num_of_meters"
4. fourth case other if the employee's job has a type of OTHER he must fill a report that includes the following fields ---> "overtime_hours"

note: all of them has the following fields in common : "content,employee_id"
each employee is prohibited from submitting a report with details that does not match their job type so the validation must ensure that the submitted report contains only the fields that are relevant to the employee's job type.
the employee cannot clock out without filling the daily report 
and for the attendence and departure history they should come together not the attandence by itself and the departure by itself and the attendence history of today won't be visible till the employee clock out 
the code must be clean and well organized and the same strucure as my other code snippets and you must use services where the logic is complex to keep the controller clean
so you're required to update the attendance and departure services to handle the new report requirements and ensure that the validation is in place and update the report feature to be as required please