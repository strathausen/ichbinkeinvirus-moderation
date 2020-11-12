FROM node:14
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app
COPY ./server/package.json /usr/src/app/
RUN npm install && npm cache clean --force
COPY ./server/ /usr/src/app
#RUN npm run build
ENV NODE_ENV production
ENV PORT 80
EXPOSE 80
CMD [ "npm", "start" ]
