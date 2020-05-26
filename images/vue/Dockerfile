# base image
FROM node:10.15.3-alpine

# set working directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# add `/usr/src/app/node_modules/.bin` to $PATH
ENV PATH /usr/src/app/node_modules/.bin:$PATH
ENV SHELL=/bin/sh
# install and cache app dependencies
COPY package.json /usr/src/app/package.json

RUN npm install --silent


# start app
CMD ["npm", "run", "dev"]