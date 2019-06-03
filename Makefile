cs:
	./vendor/fabpot/php-cs-fixer/php-cs-fixer fix --verbose

start_tika_server:
	\[ -f Tests/bin/tika-server.jar \] || wget -O Tests/bin/tika-server.jar http://archive.apache.org/dist/tika/tika-server-1.21.jar
	@make -s stop
	java -jar Tests/bin/tika-server.jar &
	sleep 10

get_tika_app:
	\[ -f Tests/bin/tika-app.jar \] || wget -O Tests/bin/tika-app.jar http://archive.apache.org/dist/tika/tika-app-1.21.jar

test: get_tika_app start_tika_server
	./vendor/bin/phpunit
	@make -s stop

stop:
	ps axu | grep tika | grep -v grep | grep -v make | awk '{print "kill -9 " $$2}' | sh

tests: test

travis_test:
	./vendor/bin/phpunit
