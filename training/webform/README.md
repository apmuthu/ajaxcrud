## Web Form with local CAPTCHA

* Here is a quick 'n dirty Web Form to acquire data from unknown entities
* The JS file included in the `webform/index.php` file should be after the form closing tag
* The `assets` folder in the upper folder is essential for this application

### Install
* Create the database and the required table as per `webform.sql`
* Create a DB User with SELECT and INSERT privileges for the database
* `FLUSH PRIVILEGES;`
* Upload the `assets` and `webform` folder
* Edit the `webform/index.php` and the `webform` table as appropriate


### Two column Radio box
* Replace lines 40-45 in `webform/index.php` with:
```php
	<div class="element-radio"><label class="title"><span class="required">*</span> Gender</label>
		<div class="column column2"><label><input type="radio" name="Gender" value="Female" required="required"/><span>Female</span></label></div><span class="clearfix"></span>
		<div class="column column2"><label><input type="radio" name="Gender" value="Male" required="required"/><span>Male</span></label></div><span class="clearfix"></span>
	</div>
```
* Line 75  in `webform/index.php` has a regex pattern for 10 digit Indian Telephone number: `pattern="[0-9]{10}"`. Change as desired.

### Tested on these Minimum Requirements
* Apache 2.2
* PHP 5.3.3
* MySQL 5

