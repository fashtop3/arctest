# base image
FROM node:10.20.1-alpine

#RUN  npm i -D webpack
# set working directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# add `/usr/src/app/node_modules/.bin` to $PATH
ENV PATH /usr/src/app/node_modules/.bin:$PATH
ENV SHELL=/bin/sh
# install and cache app dependencies
#COPY . .
COPY package.json /usr/src/app/package.json

RUN npm install --silent


# start app
EXPOSE 80
EXPOSE 8080
EXPOSE 8081
CMD ["npm", "run", "start"]