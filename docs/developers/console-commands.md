# Console Commands

Consume includes console commands you can run from your Craft project’s directory.

## Tokens

::: reference
### `consume/tokens/refresh`

Refreshes the stored access token for an OAuth client, even when it hasn’t expired. Run it to test a client’s connection or to refresh a token on a schedule outside of normal requests.

| Option | Description | Default |
| --- | --- | --- |
| `--handle` | The handle of the OAuth client whose token to refresh. Required. | |

```shell
php craft consume/tokens/refresh --handle=myClient
```
:::
