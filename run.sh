#!/bin/sh

a=10
while [ $a -ge 10 ]
do
 php artisan sync:sfa
done
