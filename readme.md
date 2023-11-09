#  QM Tutorial

## Development

If you'd like to develop from this repository, first install all of the dependencies:

`npm install`

Then run the build process in a watch mode:

`npm start`

## Running Locally

To use the included local environment, make sure Docker is running and then run the following command:

`npm run env start`

and visit [http://localhost:8888/wp-admin](http://localhost:8888/wp-admin).

You should be able to log in with Username: `admin` and Password: `password`.

[Learn more about wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/).

The local environment will also a preinstall a number of larger WordPress plugins, including WooCommerce, BuddyPress, and bbPress, to make the site feel a bit more realistic.

## Importing Fake Content

`npm run env run cli wp qm-tutorial import`

You can use the `--limit` flag to increase the number of posts you create.

`npm run env run cli wp qm-tutorial import -- --limit=500`
