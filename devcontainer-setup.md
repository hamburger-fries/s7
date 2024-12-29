# ISTA Development Container Technical Documentation

## Overview
This document provides detailed technical information about the ISTA development container setup, including all configurations, dependencies, and customizations.

## Container Structure

### Base Image
- Ubuntu (latest)
- Non-root user: vscode
- Default shell: Zsh with Oh My Zsh
- Custom prompt: Starship

### Services
1. **Workspace Container**
   - Purpose: Primary development environment
   - Base: Ubuntu with development tools
   - User: vscode (non-root with sudo)
   - Mount: Project directory at /workspace

2. **Nginx**
   - Version: latest
   - Port mappings: 80, 443
   - Configuration: Custom nginx.conf
   - Mount: Project at /var/www/html

3. **PHP-FPM**
   - Version: 8.2
   - Extensions: mysqli, pdo, pdo_mysql
   - Mount: Project at /var/www/html

4. **MariaDB**
   - Version: latest
   - Environment variables:
     - MYSQL_ROOT_PASSWORD=rootpassword
     - MYSQL_DATABASE=wordpress
     - MYSQL_USER=wpuser
     - MYSQL_PASSWORD=wppassword
   - Persistence: Named volume (db_data)

5. **phpMyAdmin**
   - Access: Port 8080
   - Connected to: MariaDB
   - Credentials: wpuser/wppassword

## Detailed Configuration

### Development Tools & Dependencies
```dockerfile
# Core development tools
zsh
curl
git
sudo
fonts-iosevka

# PHP and related tools
php
php-fpm
php-mysql
php-cli
php-curl
php-xml
php-mbstring
php-zip
php-gd
php-intl
php-bcmath
php-soap
php-xmlrpc
php-imagick
phpmyadmin
composer

# Node.js ecosystem
nodejs
npm

# Build essentials and libraries
build-essential
libssl-dev
libreadline-dev
libbz2-dev
libsqlite3-dev
libffi-dev
liblzma-dev
libncurses5-dev
libgdbm-dev
libnss3-dev
libgdbm-compat-dev
libdb5.3-dev
libexpat1-dev
libmpdec-dev
libz-dev
libjpeg-dev
libpng-dev
libfreetype6-dev
libonig-dev
libzip-dev
libpcre3-dev
libxslt1-dev
libmcrypt-dev
libpspell-dev
libedit-dev
libreadline6-dev
libtidy-dev
libxslt1.1
libmhash2
libmcrypt4
libgd-dev
libgeoip-dev
libmagickwand-dev
libmagickcore-dev
libmemcached-dev
libcurl4-openssl-dev
libssl1.1
```

### Shell Configuration

#### Zsh Setup
1. Oh My Zsh installation
2. Custom plugins:
   - git (version control)
   - docker (container management)
   - docker-compose (multi-container orchestration)
   - composer (PHP package management)
   - npm (Node.js package management)
   - node (Node.js version management)
   - zsh-autosuggestions (command suggestions)
   - zsh-syntax-highlighting (syntax highlighting)
   - fast-syntax-highlighting (enhanced syntax highlighting)
   - zsh-autocomplete (advanced completion)

#### Starship Prompt Configuration
1. Installation via curl
2. Custom configuration includes:
   - Git status integration
   - PHP version display
   - Node.js version display
   - Docker context
   - Command duration
   - Memory usage
   - Shell indicator
   - Battery status
   - Time display

### VS Code Integration

#### Extensions
1. ms-azuretools.vscode-docker
   - Docker container management
   - Dockerfile syntax support
   - Container debugging

2. bmewburn.vscode-intelephense-client
   - PHP intelligence
   - Code completion
   - Error detection

3. dbaeumer.vscode-eslint
   - JavaScript/TypeScript linting
   - Code quality checks

4. esbenp.prettier-vscode
   - Code formatting
   - Style consistency

5. bradlc.vscode-tailwindcss
   - Tailwind CSS support
   - Class completion
   - Preview features

#### Terminal Configuration
```json
{
  "terminal.integrated.fontFamily": "Iosevka Nerd Font",
  "terminal.integrated.defaultProfile.linux": "zsh",
  "terminal.integrated.profiles.linux": {
    "zsh": {
      "path": "/bin/zsh",
      "icon": "terminal"
    }
  }
}
```

### Docker Configuration

#### Network Setup
- Network mode: host
- Privileged mode enabled
- Custom bridge network for inter-container communication

#### Volume Management
1. Project files:
   - Source: Local project directory
   - Target: /workspace
   - Mount type: bind
   - Consistency: cached

2. Database:
   - Named volume: db_data
   - Persistence across container rebuilds

3. Configuration files:
   - Nginx configuration
   - PHP-FPM settings
   - MariaDB initialization

### WordPress CLI Integration
- WP-CLI installed globally
- Available as 'wp' command
- Auto-completion enabled in Zsh

## Security Considerations

### Container Security
1. Non-root user (vscode)
2. Sudo access controlled
3. SSH agent forwarding configured
4. Environment variables for sensitive data

### Database Security
1. Custom credentials
2. Named volume for persistence
3. Network isolation
4. phpMyAdmin access control

## Development Workflow

### Container Lifecycle
1. Initial build:
   ```bash
   docker compose -f .devcontainer/docker-compose.yml up -d --build
   ```

2. Stopping containers:
   ```bash
   docker compose -f .devcontainer/docker-compose.yml down
   ```

3. Rebuilding:
   ```bash
   docker compose -f .devcontainer/docker-compose.yml down -v
   docker compose -f .devcontainer/docker-compose.yml up -d --build
   ```

### Git Configuration
1. Default branch: main
2. Remote: https://github.com/SacredTexts/wordpress.git
3. Authentication: Personal Access Token
4. SSH agent forwarding enabled

## Troubleshooting

### Common Issues
1. Permission problems:
   - Check user ownership
   - Verify volume mounts
   - Confirm sudo access

2. Shell configuration:
   - Verify Zsh as default
   - Check plugin installation
   - Confirm Starship installation

3. Database connection:
   - Verify credentials
   - Check network connectivity
   - Confirm volume persistence

### Logs Access
- Container logs: `docker compose logs [service]`
- PHP-FPM logs: Available in container
- Nginx access/error logs: Configured in nginx.conf
- MariaDB logs: Available in container

## Maintenance

### Updates
1. Base images:
   - Pull latest versions
   - Rebuild containers
   - Test functionality

2. Dependencies:
   - Update package lists
   - Upgrade installed packages
   - Verify compatibility

### Backup
1. Database:
   - Use named volume
   - Regular dumps recommended
   - Version control excluded

2. Configuration:
   - All in version control
   - Regular commits
   - Push to remote repository

## Team Collaboration

### Repository Structure
```
.devcontainer/
├── Dockerfile           # Container definition
├── docker-compose.yml   # Service orchestration
├── devcontainer.json    # VS Code configuration
├── nginx.conf          # Web server configuration
├── zshrc               # Shell configuration
├── starship.toml       # Prompt configuration
└── README.md           # Setup instructions
```

### Getting Started
1. Clone repository
2. Install prerequisites:
   - Docker Desktop
   - VS Code
   - Remote Containers extension
3. Open in VS Code
4. Select "Reopen in Container"

### Best Practices
1. Keep containers ephemeral
2. Use version control for configurations
3. Document changes
4. Test before committing
5. Regular updates and maintenance
