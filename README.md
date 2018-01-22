# LoO Quotes

## Routes

All routes should be locked down with HTTP authentication headers.

* `/gen`

1. Grabs Lessons of October MD version from [https://junipermcintyre.net/politics/lessons-of-october/download](https://junipermcintyre.net/politics/lessons-of-october/download)
2. Picks a # from 1-8
3. Grabs that many lines from Lessons of October
4. Returns as string

A "line" is determined as any block of lines in the file separated by line of whitespace. Line collection is stopped when a chapter is encountered, or the end of a paragraph (two lines of whitespace).

The gen function is mostly contained in functions.php, so it can be called from anywhere in the application

* `/post`

1. Gets content from `/gen`, or `gen()`
2. Posts is to the configured Tumblr (using .env)

## Installation & configuration

1. Clone
2. Composer
3. .env with Tumblr creds
