# FeedTracker
A simple tool that allows to follow the number of RSS subscribers like Feedburner

Setup the SQL schema (dbschema.mysql)
------
```sql
CREATE TABLE IF NOT EXISTS `stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reader_id` varchar(16) NOT NULL,
  `content_id` int(10) unsigned NOT NULL,
  `read_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(16) NOT NULL,
  `referer` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reader_id` (`reader_id`,`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
```


Edit the configuration file
------

Change the $image_url with the URL of the logo of your website or a blank pixel.
Change $db vars with your MySQL server credentials.

Integrate an IMG in all you feeds that point to : tracker.php
------

```html
<img src="http://monsite.com/tracker.php?content_id=12345" alt="tracker" />
```

You can display the number of RSS readers using JQuery 
------

```javascript
$.getJSON( "stats.php", function( json ) {
  console.log( "RSS Reader count : " + json.readerCount );
 });
 ```
