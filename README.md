# Tag Manager API

 - Create OAuth 2.0 Client IDs credential at https://console.cloud.google.com/apis/credentials?project=tag-monitoring-com
   - type "web application"
   - add correct redirect URI, e.g. http://localhost:8100/login/check-google 
   - store credentials locally for later usage
  - Create OAuth consent screen on https://console.cloud.google.com/apis/credentials/consent?project=tag-monitoring-com
    - internal usage
    - whitelist test users
    - add relevant scopes, e.g. .../auth/tagmanager.manage.accounts
  - Run this app with docker compose up and authorize via http://localhost:8100/login
    - Open debug mode and copy refresh token for later usage
    - Use refresh token wherever needed
