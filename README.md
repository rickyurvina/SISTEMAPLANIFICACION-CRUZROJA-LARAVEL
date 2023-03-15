# Cruz Roja Ecuatoriana

[![Build Status](https://dev.azure.com/laverixcialtda/CRE/_apis/build/status/laverixcialtd.cre?branchName=develop)](https://dev.azure.com/laverixcialtda/CRE/_build/latest?definitionId=21&branchName=develop)

## Azure CDN Assets
### Commands
Sync assets that have been defined in the config to the CDN. Only pushes changes/new assets. Deletes locally removed files on CDN

     `php artisan asset-cdn:sync`

Pushes assets that have been defined in the config to the CDN. Pushes all assets. Does not delete files on CDN.

     `php artisan asset-cdn:push`

Deletes all assets from CDN, independent from config file.

     `php artisan asset-cdn:empty`

### Serving Assets
     Replace mix() with mix_cdn().
     Replace asset() with asset_cdn().
