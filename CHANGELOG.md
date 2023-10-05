# Changelog

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
