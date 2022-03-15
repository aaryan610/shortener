# URL Shortener

This URL Shortener is an open-source project created by Aaryan Khandelwal. It is created using php and mySQL.

### Features

  - You can shorten n number of URLS using this web app.
  - Login and store URLS for future use.
  - After logging in,  you can also manage your URLS, change their keyword, delete them, etc.

### Requirements

  - You need to run Apache and MySQL server to run the app.

### MySQL Tables

Database name, user and password is upto you. You can change the databse credentials from the `header.php` file.

##### shorturl

Fields- id, user, link, short_link, txt, hit_count, status, ver_key

##### users
Fields- id, name, username, email, password, encrypter

Do not change the order of fields.

### Development

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
