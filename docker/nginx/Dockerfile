FROM nginx:1.21.5

# install Midnight Commander
RUN apt-get update && apt-get install mc -y

# create dir "files" for symlink
RUN mkdir /var/files && \
    chown 1000:1000 /var/files