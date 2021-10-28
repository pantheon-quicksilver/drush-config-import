# Github Action

The bundled workflow includes a release script that will auto-deploy updates to Packagist. For this to work, you need to add your Packagist credentials as repository secrets (for whomever is publishing the pacakge). There are two secrets that need to be added:

- `PACKAGIST_USERNAME`: Your Packagist username
- `PACKAGIST_API_TOKEN`: Your Packagist API token (found in your [profile](https://packagist.org/profile/))
