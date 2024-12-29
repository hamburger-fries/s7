# Development Container Guide

#1 RULE - Use Linux Docker and NEVER USE WINDOWS.

## Overview
This project uses Visual Studio Code Development Containers (devcontainers) to provide a consistent development environment across all team members. The devcontainer configuration ensures everyone has the same tools, extensions, and dependencies installed.

## Setup Requirements
1. Visual Studio Code
2. Docker Desktop
3. Remote - Containers extension for VS Code
4. Use multiple containers as needed for different services and for optimal setup.
5. Clone https://github.com/hamburger-fries/s7.git

## Container Configuration
Our devcontainer is configured with:
- Linux-based container (Ubuntu latest)
- PHP 8.0
- Apache web server
- MySQL 8.0
- phpMyAdmin
- Common development tools and utilities
- Starship terminal + Ohmyzsh with powerlevel10k theme and Zsh-autosuggestions Plugin and Zsh-syntax-highlighting Plugin
- Set ZSH as default in the Devcontainer and in VSCODE
## Getting Started
1. Clone the repository
2. Open the project in VS Code
3. When prompted "Reopen in Container", click "Reopen in Container"
   - Alternatively, use Command Palette (F1) and select "Remote-Containers: Reopen in Container"
4. Wait for the container to build and start (first time will take longer)

## Container Features
- Pre-configured PHP development environment
- MySQL database service
- phpMyAdmin for database management
- Automatic port forwarding:
  - Web server: localhost:80
  - MySQL: localhost:3307
  - phpMyAdmin: localhost:8083

## Best Practices
1. Always work inside the container when developing
2. Use the provided tools and extensions
3. Keep devcontainer configuration in version control
4. Document any additional dependencies in this guide

## Troubleshooting
1. If container fails to build:
   - Check Docker is running
   - Try "Rebuild Container" from Command Palette
2. If services are unreachable:
   - Verify ports are not in use by other applications
   - Check Docker network settings

## Container Structure
```
.devcontainer/
├── devcontainer.json    # VS Code devcontainer configuration
├── Dockerfile          # Container image definition
└── docker-compose.yml  # Multi-container Docker composition
```

## Environment Variables
Environment variables are configured in docker-compose.yml:
- MYSQL_ROOT_PASSWORD: "pass"
- MYSQL_DATABASE: s72_wprasta
- MYSQL_USER: s72_ocean
- MYSQL_PASSWORD: hardnugs

## Additional Resources
- [VS Code Remote Development](https://code.visualstudio.com/docs/remote/remote-overview)
- [Developing inside a Container](https://code.visualstudio.com/docs/remote/containers)
- [DevContainer Reference](https://code.visualstudio.com/docs/remote/devcontainerjson-reference)
