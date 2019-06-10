## Music App
[![CircleCI](https://circleci.com/gh/Oloyedesinmiloluwa/musicApp/tree/develop.svg?style=svg)](https://circleci.com/gh/Oloyedesinmiloluwa/musicApp/tree/develop)
[![Maintainability](https://api.codeclimate.com/v1/badges/9a19bda3618351d0bb8f/maintainability)](https://codeclimate.com/github/Oloyedesinmiloluwa/musicApp/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9a19bda3618351d0bb8f/test_coverage)](https://codeclimate.com/github/Oloyedesinmiloluwa/musicApp/test_coverage)

This is a Laravel based application RESTful API. It is a platform for artiste to create album, add tracks and for users to play/download the tracks.
You can access the hosted app here https://my-musicapp.herokuapp.com/api/v1/tracks

## Setup

After cloning this repo, run the following commands

- `composer update`
- `cp .env.example .env` (please update your environment variable appropriately)
- `php artisan migrate` (after creating a database with a name of your choice)
- `php artisan serve`

## Test

This app is tested with PHPunit and can be run with the command below

- `composer test`

## Technologies

- PHP 7.3
- Laravel 5.8

## Endpoints

- Delete a Track `http://host_address/api/v1/tracks/{trackid}` (DELETE)
- Login `http://host_address/api/v1/auth/login` (POST)
- Register `http://host_address/api/v1/users/` (POST)
- Update profile `http://host_address/api/v1/users/profile` (PUT)
- Add track to playlist `http://host_address/api/v1/playlists/{playlistId}/track/{track_id}` (PUT)
- Create Playlist `http://host_address/api/v1/playlists` (POST)
- Add Track to an Album `http://host_address/api/v1/albums/{albumId}/track/{trackId}` (PUT)
- Create Genres `http://host_address/api/v1/genres `(POST)
- Get ratings of a Track `http://host_address/api/v1/tracks/{trackId}/ratings` (GET)
- Create an Album `http://host_address/api/v1/albums` (POST)
- Download a track `http://host_address/api/v1/tracks/{trackId}/download` (GET)
- Rate a Track `http://host_address/api/v1/tracks/{trackId}/rate` (PUT)
- Get all tracks `http://host_address/api/v1/tracks` (GET)
- Favourite a track `http://host_address/api/v1/tracks/{trackId}/favourite` (PUT)
- Create a track `http://host_address/api/v1/tracks/` (POST)

## Contributing

More info regarding contribution is coming soon, if you think you are waiting till forever, please feel free to give up :)

## License

The open-source software is licensed under the [MIT license](https://opensource.org/licenses/MIT).
