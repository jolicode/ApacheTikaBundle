cs:
	./vendor/fabpot/php-cs-fixer/php-cs-fixer fix --verbose

start_tika_server:
	\[ -f Tests/bin/tika-server.jar \] || wget -O Tests/bin/tika-server.jar http://apache.mirrors.ovh.net/ftp.apache.org/dist/tika/tika-server-1.11.jar
	java -jar Tests/bin/tika-server.jar &
	sleep 10

get_tika_app:
	\[ -f Tests/bin/tika-app.jar \] || wget -O Tests/bin/tika-app.jar http://apache.mirrors.ovh.net/ftp.apache.org/dist/tika/tika-app-1.11.jar

test: get_tika_app start_tika_server
	./vendor/bin/phpunit
	ps | grep tika | grep -v grep | awk '{print "kill -9 " $$1}' | sh

tests: test
