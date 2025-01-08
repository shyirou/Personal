# Menggunakan image PHP sebagai base image
FROM php:8.0-cli

# Install libpq-dev untuk PostgreSQL dan ekstensi PHP terkait
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Menentukan direktori kerja
WORKDIR /app

# Menyalin file aplikasi ke dalam container
COPY . /app

# Menjalankan server PHP built-in untuk pengembangan
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
