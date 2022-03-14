#FROM fluent/fluentd:v0.12-debian

##RUN ["gem", "install", "fluent-plugin-elasticsearch", "--no-rdoc", "--no-ri", "--version", "1.9.2"]
#RUN ["gem", "install", "fluent-plugin-elasticsearch", "--version", "1.9.2"]


#FROM fluent/fluentd:v1.10-1

#USER root

#RUN apk add --no-cache --update --virtual .build-deps \
#	sudo build-base ruby-dev \
#	# cutomize following instruction as you wish
#	&& sudo gem install fluent-plugin-elasticsearch \
#	&& sudo gem sources --clear-all \
#	&& apk del .build-deps \
#	&& rm -rf /home/fluent/.gem/ruby/2.5.0/cache/*.gem

##COPY fluentd/fluent.conf /fluentd/etc/
#COPY entrypoint.sh /bin/

#USER fluent

FROM fluent/fluentd:v1.12.0-debian-1.0

USER root

RUN ["gem", "install", "fluent-plugin-elasticsearch", "--no-document", "--version", "5.0.3"]

RUN ["mkdir", "/output"]

RUN ["chown", "fluent:fluent", "/output"]

# RUN ["chmod", "-R", "777", "/output"]

USER fluent