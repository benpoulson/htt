FROM node:latest
MAINTAINER Ben Poulson <benpoulson@protonmail.ch>
WORKDIR /home/node/
EXPOSE 4200

COPY --chown=node:node . /home/node/
RUN npm install
CMD npm start
