## To set up the project:

1) cd projects/
2) git clone https://github.com/ZATTARA1990/exchange_rates_service.git
3) cd exchange_rates_service/
4) composer install
5) symfony server:start

## To update exchange rates
- run command `bin/console app:update-currency-exchange-rate`. Result is saved into var/rates.json file

## To get list of rates via API call
- http://localhost:8000/exchange-rates?base_currency=EUR . base_currency parameter is optional.

## To use currency converter 
- http://localhost:8000/convert-currency?currency_from=USD&currency_to=EUR&amount=100