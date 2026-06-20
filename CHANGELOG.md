# Changelog

## 2.0.15 - 2026-06-20

### Fixed
- Fix an issue where `format: 'raw'` would fail for OAuth client requests that return already-parsed string content.

## 2.0.14 - 2026-05-30

### Fixed
- Fix an issue where client scopes aren’t normalized.

## 2.0.13 - 2026-05-14

### Changed
- Update `fetchData()` logic to set the cache data for requests.

## 2.0.12 - 2026-05-03

### Changed
- Bump `verbb/auth` to allow `firebase/php-jwt` 7.x.

## 2.0.11 - 2026-03-28

### Added
- Add the ability to override the default Redirect URI as a plugin setting.

## 2.0.10 - 2026-02-07

### Fixed
- Fix a redirect error when connecting to a client in the control panel.
- Fix an error when creating a new client.

## 2.0.9 - 2026-01-23

### Changed
- Bump `verbb/auth`.

## 2.0.8 - 2025-11-06

### Added
- Add better trace information for logging when connecting to OAuth provider.

## 2.0.7 - 2025-09-16

### Added
- Add username and password to Generic OAuth client settings.

### Fixed
- Fix “Authorization URL” and “Token URL” from being shown for a “Client Credentials” type client.
- Fix error handling for duplicate-named clients.

## 2.0.6 - 2025-08-13

### Added
- Add support for `raw` response handling for requests.

## 2.0.5 - 2025-07-18

### Changed
- Update `symfony/property-access` and `symfony/serializer` dependency.

## 2.0.4 - 2025-07-18

### Changed
- Update English translations.
- Update status indicator.

## 2.0.3 - 2025-04-12

### Changed
- Update GitHub, GitLab and PayPal provider classes to be proper case.

## 2.0.2 - 2025-02-03

### Added
- Add CA to Zoho domains.
- Add `consume/tokens/refresh` console command.

### Fixed
- Fix backward compatibility check for custom clients and proxy field setting support.
- Fix status indicators.
- Fix deleting a client not working from the editing client interface.

## 2.0.1 - 2024-07-21

### Changed
- Update English translations.

### Fixed
- Fix Generic OAuth provider now parsing .env variables for Auth/Token/API URLs.

## 2.0.0 - 2024-05-13

### Added
- Add improved session-handling for authorization and callback methods, to improve failed sessions in some cases.

### Changed
- Now requires PHP `8.2.0+`.
- Now requires Craft `5.0.0+`.

## 1.0.18 - 2026-05-03

### Changed
- Bump `verbb/auth` to allow `firebase/php-jwt` 7.x.

## 1.0.17 - 2025-09-16

### Added
- Add username and password to Generic OAuth client settings.

### Fixed
- Fix “Authorization URL” and “Token URL” from being shown for a “Client Credentials” type client.
- Fix error handling for duplicate-named clients.

## 1.0.16 - 2025-08-12

### Added
- Add support for `raw` response handling for requests.

## 1.0.15 - 2025-07-18

### Changed
- Update `symfony/property-access` and `symfony/serializer` dependency.

## 1.0.14 - 2025-07-18

### Changed
- Update English translations.

## 1.0.13 - 2025-02-03

### Added
- Add CA to Zoho domains.

## 1.0.12 - 2024-07-21

### Changed
- Update English translations.

### Fixed
- Fix Generic OAuth provider now parsing .env variables for Auth/Token/API URLs.

## 1.0.11 - 2024-04-29

### Added
- Add support for `headlessMode` redirect URIs.

### Changed
- Update English translations.

## 1.0.10 - 2024-04-05

### Added
- Add improved session-handling for authorization and callback methods, to improve failed sessions in some cases.

## 1.0.9 - 2024-02-08

### Added
- Add `includeErrorResponse` as a request option to allow API errors to be returned in an `error` property.
- Add `Service::EVENT_BEFORE_FETCH_DATA` event to handle before data is fetched. (thanks @markhuot).

### Fixed
- Fix Zoho not working for multiple data centers.

## 1.0.8 - 2023-12-18

### Fixed
- Fix requests not working correctly when either the `uri`, `url` or `baseUri` contained a dot character, or ended in a filename.

## 1.0.7 - 2023-12-17

### Fixed
- Fix requests not working correctly when either the `uri`, `url` or `baseUri` contained a dot character, or ended in a filename.

## 1.0.6 - 2023-12-17

### Added
- Add Fedex client.
- Add the ability to set different grants on generic OAuth clients.

## 1.0.5 - 2023-12-08

### Fixed
- Fix Google offline access type.

## 1.0.4 - 2023-10-05

> {warning} If you are using LinkedIn, your LinkedIn app will need to now include the **Sign In with LinkedIn using OpenID Connect** product.

### Changed
- Change LinkedIn to use new OpenID Connect API.

## 1.0.3 - 2023-05-27

### Added
- Add “Use Sandbox” setting for DocuSign and PayPal.

## 1.0.2 - 2023-04-21

### Fixed
- Fix CP-based generic clients not accepting .env variables for some settings.

## 1.0.1 - 2023-04-21

### Changed
- Change caching behaviour to only cache `GET` requests.

### Fixed
- Fix CP-based clients not having their cache cleared when updated.
- Fix Redirect URI not working correctly for multi-sites.

## 1.0.0 - 2023-02-07

### Added
- Initial release
