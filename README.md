This Repo is the submission by Maharsh Mangal for a simple core Php backend

## Installation
1. Clone the repository
2. Run the SQL file in the database to obtain sample data
3. Change the database credentials in the `config/Database.php` file
4. Hit the following API endpoints to get the desired output
5. The API endpoints are as follows:
    - `POST /api/user/register.php` : To Register the user
    - `POST /api/user/login.php` : To login with a specific user
       - The login API will return a token which will be required to be sent as a bearer token for all subsequent requests
    - `GET /api/song/getByUser.php` : To get the list of all the songs for a specific user
    - `POST /api/playlist/create` : To create a playlist
    - `POST /api/playlist/addSong` : To add a song to a playlist