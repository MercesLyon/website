FROM library/node

RUN apt-get update -y

ENV PATH="/var/www/symfony/node_modules/.bin:${PATH}"

ARG uid
RUN usermod -u $uid node
RUN groupmod -g $uid node

# Define default command.
CMD ["bash"]
