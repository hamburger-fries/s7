FROM ubuntu:jammy

# Prevent tzdata questions
ENV DEBIAN_FRONTEND=noninteractive

# Add PHP repository
RUN apt-get update && apt-get install -y software-properties-common \
    && add-apt-repository -y ppa:ondrej/php

# Install system dependencies
RUN apt-get update && apt-get install -y \
    apache2 \
    php8.0 \
    php8.0-cli \
    php8.0-common \
    php8.0-mysql \
    php8.0-zip \
    php8.0-gd \
    php8.0-mbstring \
    php8.0-curl \
    php8.0-xml \
    php8.0-bcmath \
    git \
    curl \
    zip \
    unzip \
    sudo \
    default-mysql-client \
    zsh \
    fonts-powerline \
    wget \
    && apt-get clean

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Apache
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add non-root user
RUN useradd -m -s /bin/zsh vscode \
    && echo "vscode ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/nopasswd

# Switch to non-root user
USER vscode

# Install Oh My Zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

# Install Starship
RUN curl -sS https://starship.rs/install.sh | sh -s -- --yes

# Install powerlevel10k theme
RUN git clone --depth=1 https://github.com/romkatv/powerlevel10k.git ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/themes/powerlevel10k

# Install Zsh plugins
RUN git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/plugins/zsh-autosuggestions
RUN git clone https://github.com/zsh-users/zsh-syntax-highlighting ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/plugins/zsh-syntax-highlighting

# Configure Zsh
RUN echo 'eval "$(starship init zsh)"' >> ~/.zshrc && \
    sed -i 's/ZSH_THEME="robbyrussell"/ZSH_THEME="powerlevel10k\/powerlevel10k"/' ~/.zshrc && \
    sed -i 's/plugins=(git)/plugins=(git zsh-autosuggestions zsh-syntax-highlighting)/' ~/.zshrc

# Set working directory
WORKDIR /var/www/html

# Start Apache on container startup
CMD ["sudo", "apache2ctl", "-D", "FOREGROUND"]
