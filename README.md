# urlshortener
A php code to shorten a given url.

NOTE:-
You need to create a Mysql DB and table named "short_urls" with id, code, url, count, created_date and status as their fields
CREATE TABLE `short_urls` (
  `id` int NOT NULL,
  `code` varchar(25) COLLATE utf8_swedish_ci NOT NULL,
  `url` text COLLATE utf8_swedish_ci NOT NULL,
  `count` int NOT NULL,
  `created_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_swedish_ci;

This repositry contains 3 files:

1. config.php - where all global variables for the site and db config are defined as well as function for creating the random string for the unique url,validating the url are performed.

2. index.php - where all UI related for the url shortner is done. It contains both html and the script.

3. shorturl.php - this is where the php functionality is done.

