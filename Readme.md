# Social Connect.
A multi Channel Social Connector for TYPO3-Neos.Project for Google Summer Of Code .
## Working now:
* Facebook Publishing of Text

## Setup:
* Clone the Repo
* Add "facebook/php-sdk-v4" : "4.0.*" in your composer.json file and run composer update
* Replace APP ID and access token's with your access tokens
* Run Neos.

## Access Tokens:
* Access tokens are required for an app to post on behalf of a user.
* There are 2 scenarios here,where the user would want to post to be shared on his personal wall and the other scenario being shared on his page.
* If you want to post to a user wall you need to update your access token every 2 months,where as page tokens are valid forever

### User Feed:
* Get a Facebook developer account if you don't have one. [Click Here](https://developers.facebook.com/)
* Create a Facebook App in the dashboard
* Head over to the [Facebook Graph API Explorer](https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Did%2Cname&version=v2.0)
* Choose your app in the application tab and click on generate access token,be sure to select the permission to access and write on the feed.
* Convert this access token into a long lived one by https://graph.facebook.com/oauth/access_token?client_id=< your FB App ID> &client_secret=
< your FB App secret> &grant_type=fb_exchange_token&fb_exchange_token=< your short-lived access token>
* Grab the long lived token and paste in the Settings.yaml of this Package,along with app id and app secret,set the user to 'me'.

### Page Access:
* Make sure you are the admin of the page you want to post to.
* Get a Facebook developer account if you don't have one. [Click Here](https://developers.facebook.com/)
* Create a Facebook App in the dashboard
* Head over to the [Facebook Graph API Explorer](https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Did%2Cname&version=v2.0)
* Make sure you add the manage_pages permission
* Choose your app in the application tab and click on generate access token,be sure to select the permission to access and write on the feed.
* Convert this access token into a long lived one by https://graph.facebook.com/oauth/access_token?client_id=< your FB App ID> &client_secret=
< your FB App secret> &grant_type=fb_exchange_token&fb_exchange_token=< your short-lived access token>
* Make a Graph API call to see your accounts using the new long-lived access token: https://graph.facebook.com/me/accounts?access_token=< your long-lived access token>
* Grab the access token for your page and check if it does not expire [Debug token](https://developers.facebook.com/tools/debug)
* Grab the permanent token and paste in the Settings.yaml of this Package,along with app id and app secret,set the user to 'page id'.

