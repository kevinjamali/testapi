# Test Api
This is just a test api has been written in PHP

##Install

There is no install and you can use it by testapi.php in a PHP ready Linux or Windows server
API file: tespapi.php
HTML test: index.php 

##Usage
/testapi.php?from=strat_date-time&to=end_datetime&type=one_of_4_defined_types&convertparam=one_of_3_defined

defined type: seconds, minutes, hours, years
defined convertparam: days, weekdays, completeweeks

'from' or 'to' examples:
2012/11/26
2012-03-24 17:45:12
24 March 2012 17:45:12
11 Feb 2021 GMT

Please don't use d m Y format like: 26/11/2020

##Time Zone

Please use standard timezone from this list: https://www.php.net/manual/en/timezones.php at the end of date-time for 'from' and 'to'

## Author
Kevin Jamali

## Screenshot
![Json result](https://github.com/kevinjamali/testapi/blob/main/images/tetsapi-json.png)


## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE.md) file for details
