=== Xoxzo - SMS and voice notification plugin for WooCommerce  ===

Contributors: xoxzo
Donate link: None
Tags: sms, voice, calls, notifications, woocommerce
Requires at least: 1.0
Tested up to: 5.3.2
Stable tag: 1.0
Requires PHP: 5.2.4
License: MIT
License URI: https://opensource.org/licenses/MIT

==  Description == 

This plugin triggers sms and voice call using xoxzo telephony service.  
Some triggers are based on woocommmerce email events.

The following are events that trigger sms/voice notification:

1. New order   
 - Pending to processing/completed/on-hold 
 - Failed to processing/completed/on-hold 
2. Cancelled order
 - Processing to cancelled
 - On-hold to cancelled
3. Failed order
 - On-hold to failed
 - Pending to failed
4. Order on-hold
 - Pending to on-hold
 - Failed to on-hold
5. Processing order
 - Failed to processing
 - On-hold to processing
 - Pending to processing
6. Completed order
7. Fully refunded order
8. Partially refunded order
9. Low stock
10. No stock
11. Order details(Resending order information)
12. Customer note
13. Reset password
14. New account

== Installation ==

1. This plugin can be install as it is.
2. The plugin uses xoxzo php client library. The library is in 'xoxzo_cloudphp' folder, to move the plugin to any directory change the following line:

 In file admin/wc-xoxzo-admin.php line 71:

        require_once $plugin_dir."/xoxzo_cloudphp/src/XoxzoClient.php";


3. .htaccess is placed in root of the plugin folder, and library folder to prevent public facing file enumeration(May require different method for other types of servers)

 [In the plugin root:]

 Options All -Indexes   
 <Files .htaccess, admin, includes, languages, xoxzo_cloudphp, start.php, uninstall.php, LICENSE.txt, README.md>   
   Order allow,deny   
   Deny from all  
 </Files>

 [In xoxzo_cloudphp folder]:

 # Disable directory browsing   
 Options All -Indexes   
 # Deny all http request   
 order deny,allow   
 deny from all

== Frequently Asked Questions ==

1. Does sms and voice behave the same?  
    Almost. For order cancel, and sms is send to admin when customer cancel, to customer when admin cancel. For voice, the default behave is always sending to admin.(Regardless who cancel).

2. How does customer cancel?  
    A cancel button will appear for each item in an order, when the order is in "pending payment" status. This is woocommerce behavior, under 'My Account' page.

3. Why does my cost of sending sms/voice is showing zero?  
    Refresh to see the updated status of each sms/voice call. This status is retrieved from Xoxzo telephony service.

4. Can I add sms/voice callback for any events in WooCommerce/WordPress?  
    Such functionality is not supported at the moment(Nor is recommended).

5. I enabled sms/voice for a particular events, but i don't see it under sms and voice status.  
    Try checking in 'Error Status' 

6. How does the cost of each sms/voice work?  
    Refer to Xoxzo pricing page

 == Screenshots ==

1. None 

== Changelog ==

= 1.0 =   
* First version *

== Upgrade Notice ==

= 1.0 =
* First version of Xoxzo WooCommerce plugin *

