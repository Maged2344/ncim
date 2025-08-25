# NCIM - Drupal CMS Project

This is a Drupal CMS-based project built on Drupal 11, offering smart defaults and enterprise-grade tools for content management. The project includes various content types, SEO tools, accessibility features, and more.

## Project Overview

NCIM is a comprehensive content management system built on Drupal CMS, featuring:

- **Content Types**: Blog, News, Events, Case Studies, Projects, People, and more
- **SEO Tools**: Advanced SEO configuration and tools
- **Accessibility**: Built-in accessibility features and tools
- **AI Integration**: AI-powered content management features
- **Forms & Analytics**: Webform integration and Google Analytics
- **Custom Theme**: NCIM theme with modern UI/UX

## Technology Stack

- **Drupal Core**: 11.x (Release Candidate)
- **PHP**: 8.1+ (as required by Drupal 11)
- **Database**: MySQL/MariaDB or PostgreSQL
- **Web Server**: Apache or Nginx
- **Composer**: For dependency management

## Prerequisites

- PHP 8.1 or higher
- Composer 2.8+
- MySQL 5.7+ or PostgreSQL 10+
- Web server (Apache/Nginx)
- Git

## Installation

### Option 1: Using DDEV (Recommended for Development)

1. Install DDEV following the [documentation](https://ddev.com/get-started/)
2. Clone this repository:
   ```bash
   git clone <your-repository-url>
   cd ncim
   ```
3. Configure and start DDEV:
   ```bash
   ddev config --project-type=drupal11 --docroot=web
   ddev start
   ```
4. Install dependencies:
   ```bash
   ddev composer install
   ddev composer drupal:recipe-unpack
   ```
5. Launch the site:
   ```bash
   ddev launch
   ```

### Option 2: Manual Installation

1. Clone this repository:
   ```bash
   git clone <your-repository-url>
   cd ncim
   ```
2. Install Composer dependencies:
   ```bash
   composer install
   ```
3. Configure your web server to point to the `web/` directory
4. Create and configure your database
5. Run the Drupal installer or use Drush:
   ```bash
   ./vendor/bin/drush site:install --db-url=mysql://user:pass@localhost/dbname
   ```

## Project Structure

```
ncim/
├── config/                 # Drupal configuration files
├── recipes/               # Drupal recipes for features
├── web/                   # Web root directory
│   ├── core/             # Drupal core files
│   ├── modules/          # Custom and contrib modules
│   ├── themes/           # Custom and contrib themes
│   └── sites/            # Site-specific files
├── vendor/                # Composer dependencies
├── composer.json          # Project dependencies
└── .gitignore            # Git ignore rules
```

## Available Features

### Content Types
- **Blog**: Blog posts with rich text editing
- **News**: News articles with publishing workflow
- **Events**: Event management with dates and registration
- **Case Studies**: Success stories and project showcases
- **Projects**: Portfolio and project management
- **People**: Team member profiles and contact information
- **Pages**: Basic page content type

### Modules
- **SEO Tools**: Advanced SEO configuration
- **Accessibility Tools**: WCAG compliance features
- **AI Integration**: AI-powered content suggestions
- **Forms**: Webform integration for contact forms
- **Analytics**: Google Analytics integration
- **Search**: Enhanced search functionality
- **Image Management**: Advanced image handling and optimization

## Development

### Adding New Features
1. Create a new Drupal recipe in the `recipes/` directory
2. Configure the recipe in `recipe.yml`
3. Run `composer drupal:recipe-unpack` to apply changes

### Custom Theme Development
The project includes a custom NCIM theme located at `web/themes/custom/ncim_theme/`. To modify:
1. Edit theme files in the theme directory
2. Clear Drupal cache after changes
3. Use `ddev drush cr` to clear cache in DDEV environment

### Custom Modules
Place custom modules in `web/modules/custom/` directory.

## Configuration Management

This project uses Drupal's configuration management system. Configuration files are stored in the `config/` directory and can be:
- Exported: `ddev drush config:export`
- Imported: `ddev drush config:import`

## Deployment

### Production Deployment
1. Ensure all configuration is exported and committed
2. Deploy code to production server
3. Run `composer install --no-dev --optimize-autoloader`
4. Import configuration: `drush config:import`
5. Clear all caches: `drush cr`

### Environment-Specific Settings
- Use `sites/*/settings.local.php` for local development
- Use environment variables for production settings
- Never commit sensitive information like database credentials

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Make your changes
4. Commit your changes: `git commit -am 'Add some feature'`
5. Push to the branch: `git push origin feature/your-feature`
6. Submit a pull request

## Support

- **Documentation**: [Drupal User Guide](https://www.drupal.org/docs/user_guide/en/index.html)
- **Community**: [Drupal.org](https://drupal.org)
- **Issues**: Report issues in the project issue queue

## License

This project is licensed under the [GNU General Public License, version 2 or later](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html).

## Acknowledgments

- Built on [Drupal CMS](https://www.drupal.org/project/drupal_cms)
- Drupal community and contributors
- All recipe maintainers and contributors
