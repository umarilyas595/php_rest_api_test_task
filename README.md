# Please follow the following steps

# Run the following command to install the dependencies
composer install

# Move to the project directory
cd [project-dir]

# To start the project run the following command
php spark serve

# To convert the CSV into the JSON and XML run the following command
Make sure PHP is installed on the server and available on $PATH.
The example file (example.csv) can be found on the root of the project.
cd public
php .\index.php convert_csv

# Use the following urls to retrieve data from rest api
# JSON responses
http://localhost:8080/
http://localhost:8080/?name=Atlantis%20The%20calm
http://localhost:8080/?discount_percentage=10

# XML responses
http://localhost:8080/?type=xml
http://localhost:8080/?name=Atlantis%20The%20calm&type=xml
http://localhost:8080/?discount_percentage=10&type=xml