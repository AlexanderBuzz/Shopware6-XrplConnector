# XrplConnector Plugin [WIP - will deprecate and re-emerge as LedgerDirect Shopware6]

XRPL connector plugin. Enables Shopware6 to receive payments in XRP.

For security reasons this plugin is hardcoded to use the Testnet.

## Prerequisites
- Shopware6 v6.4.x
- gmp PHP extension present (for the time being)

## Installation
```
bin/console plugin:refresh
bin/console plugin:install XrplConnector --activate
```