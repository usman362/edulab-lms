#!/bin/sh
PATH=/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin
echo "Cron job started at $(date)" >> /home/u385006707/domains/edulab.hivetheme.com/public_html/cron.log
/usr/bin/php /home/u385006707/domains/edulab.hivetheme.com/public_html/artisan queue:work --tries=3 >> /home/u385006707/domains/edulab.hivetheme.com/public_html/cron.log 2>&1
echo "Cron job finished at $(date)" >> /home/u385006707/domains/edulab.hivetheme.com/public_html/cron.log