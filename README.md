Queue-it
========

Queue-it is an online queue system designed to manage website overload during extreme end-user peaks.
It offers an API for programmatic access to configuring and controlling the queue.

About module
============

This module is unofficial implementation of [Queue-it Framework](https://queue-it.com/) for Drupal CMS.
You need to have existing Queue-it account in order to use it.

Authentication
==============

In order to authenticate and authorize the `Api-Key`, HTTP header must be supplied in the REST request.
The key can be found in the [GO Queue-it Platform](https://go.queue-it.net/account/security).

This API Key should be specified in the settings page of the module at `admin/config/services/queueit`.

Dependencies
============

The module depends on [Known User Implementation for PHP](https://github.com/queueit/KnownUser.V3.PHP)
hosted at GitHub repository.

With composer, setting up things is fairly easy.

1. Download and install the [Composer Manager module](https://drupal.org/project/composer_manager).

2. Run the drush command: `drush composer-manager install`.

   If you are already using `composer_manager` with other modules, simply run:
   "drush composer-manager update"
   This should set up all of your dependencies and all of the libraries necessary
   to run behat tests.

To check if the library has been installed, as admin visit /admin/config/system/composer-manager page.

By default, `composer_manager` will place all of the libraries at /sites/all/vendor.
Inside of the vendor directory there is a bin directory and inside of it we can
find the behat executable.

KnownUser API
=============

You can use the Known user setting to test if a specific user has arrived at your site via the queue,
or if the user has tried to bypass the queue. The KnownUser validation must only be done on page requests.

Notes
=====

- Queue-it Security Documentation can be found at: <http://securitydoc-assets.queue-it.net>.
- The latest version and API (2) documentation can be found at: <https://api2.queue-it.net/>.
- Older versions [API1](http://api.queue-it.net) has been deprecated now.
- The service will accept both XML and JSON formatted data by setting the `Content-Type` HTTP header.
- Source code and binaries are available at [Github](https://github.com/queueit).
- For support of Queue-it Implementation, please contact Queue-itsupport at <support@queue-it.net>.
