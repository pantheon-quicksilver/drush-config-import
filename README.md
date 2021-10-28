# Quicksilver Template

This is template for new Quicksilver projects to utilize so that Quicksilver scripts can be installed through Composer.

## Requirements

While these scripts can be downloaded individually, they are meant to work with Composer. See the installation in the next section.

- Quicksilver script projects and the script name itself should be consistent in naming convention.
- README should include a recommendation for types of hooks and stages that the script should run on.
  - For example, "This script should run on `clone_database` and the `after` stage.
  - Provide a snippet that can be pasted into the `pantheon.yml` file.

### Installation

This project is designed to be included from a site's `composer.json` file, and placed in its appropriate installation directory by [Composer Installers](https://github.com/composer/installers).

In order for this to work, you should have the following in your composer.json file:

```json
{
  "require": {
    "composer/installers": "^1"
  },
  "extra": {
    "installer-paths": {
      "web/private/scripts/quicksilver": ["type:quicksilver-script"]
    }
  }
}
```

The project can be included by using the command, where `{quicksilver-project}` represents the name of the Quicksilver script:

`composer require pantheon-quicksilver/{quicksilver-project}:^1`

If you are using one of the example PR workflow projects ([Drupal 8](https://www.github.com/pantheon-systems/example-drops-8-composer), [Drupal 9](https://www.github.com/pantheon-systems/drupal-project), [WordPress](https://www.github.com/pantheon-systems/example-wordpress-composer)) as a starting point for your site, these entries should already be present in your `composer.json`.

### Example `pantheon.yml`

Here's an example of what your `pantheon.yml` would look like if this were the only Quicksilver operation you wanted to use.

```yaml
api_version: 1

workflows:
  sync_code:
    after:
      - type: webphp
        description: Run Quicksilver script
        script: private/scripts/quicksilver/pantheon-quicksilver/quicksilver-template.php
```
