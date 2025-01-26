## Recruitment task - Junior Fullstack Appverk

### Setting up
This project is built in Laravel using sail, for more information on how to
boot up the project look up Laravel's docs. 
For this project to work you will need docker.
Before starting up the containers, make .env file based on .env.example, generate app key.
Also, don't forget to run the migrations :)

### Routes
There are 2 routes:
- POST `/modules` - creates module instance in the database, used for generating html, css and js files.
  - parameters: 
    - `width` - width of the element in css file, represented in `rem` units
    - `height` - height of the element in css file, represented in `rem` units
    - `color` - color of the element's background, represented by css acceptable color values (e.g. `red` or hexcode)
    - `link` - an url to a page, that will open when clicking on the element
  - returns `id` of newly created element (`HTTP 201`) or `HTTP 422` in case the entity wasn't created
- GET `/modules/{id}/download` - forces browser to download a zip file with html, css and js component files

### Examples
Here's an example curl request for POST `/modules`:
```
curl --location 'http://localhost:2000/modules' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'width=5' \
--data-urlencode 'height=7' \
--data-urlencode 'color=red' \
--data-urlencode 'link=https://www.google.com'
```
