# Changelog

All notable changes to the package will be documented in this file.

## v1.3.3 - 2022-12-02

- Fix provider configuration update in cases where configuration data is multi-assoc
  or doesn't accept null values

## v1.3.2 - 2022-11-09

- Fix html-escaping of provision result params/data/debug/logs accordion panels
- Fix "Next Request" parameter data to be recursive **replace** of params and result

## v1.3.1 - 2022-11-08

- Update "Next Request" parameter data to be recursive merge of params and result

## v1.3.0 - 2022-11-08

- Require upmind/provision-provider-base ^3.5
- Add stderr to logging stack
- Add new form components
- Update provision-request-new and provision-request-show views to use new form
  components
- Minor UI improvements

## v1.2.0 - 2022-10-26

- Add duplicate provider configuration button
- Fix provision-request-show result_data_rules for nested datasets
- UI tweaks

## v1.1.0 - 2022-10-20

- Update upmind/provision-provider-base to v3.4.0
- Update guzzlehttp/guzzle to v7.5.0
- Fix a crash related to uninstalled provision categories/providers
- Add "Next Request" button when viewing a provision request which merges the
  result data into the new request's parameter data form
- Various UI/UX tweaks

## v1.0.7 - 2022-10-17

- Update upmind/provision-provider-base to v3.1.1

## v1.0.6 - 2022-10-17

- Display result data property validation rules in an info tooltip or a warning
  if a property is unexpected

## v1.0.5 - 2022-10-17

- Prefer source when installing upmind/* packages and auto for everything else

## v1.0.4 - 2022-10-17

- Add duplicate button to provision request index view
- Add delete button to provision request index view

## v1.0.3 - 2022-10-17

- Add PHP ^7.4 version constraint

## v1.0.2 - 2022-10-15

- Update upmind/provision-provider-base to v3.1.0 so all Provider instances get a
  logger instance set on them

## v1.0.1 - 2022-10-15

- Minor UI tweaks

## v1.0.0 - 2022-10-15

- Initial public release