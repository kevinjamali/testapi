# Test Api
This is just a  date time test API has been written in PHP to calculate dyas, weekdays and complete week between 2 date 

##Install

There is no install and you can use it by testapi.php in a PHP ready Linux or Windows server
API file: index.php
HTML test: test.php 

##Usage
/index.php?from=strat_date-time&to=end_datetime&type=one_of_4_defined_types&convertparam=one_of_3_defined

allowed type: seconds, minutes, hours, years
allowed convertparam: days, weekdays, completeweeks

Suggested formats for 'from' and 'to' are 'ISO 8601 date' and 'RFC 2822'
examples:
2012-03-24 17:45:12
24 March 2012 17:45:12
11 Feb 2021 GMT

you can use m/d/Y format like 2012/11/26 but Please don't use d/m/Y format like: 26/11/2020

##Time Zone

Please use standard timezone from this list: https://www.php.net/manual/en/timezones.php at the end of date-time for 'from' and 'to'

## Author
Kevin Jamali

## Screenshot
![Json result](https://github.com/kevinjamali/testapi/blob/main/images/tetsapi-json.png)


## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE.md) file for details
