export default ({ env }) => ({
  'strapi-plugin-sso': {
    enabled: env.bool('SSO_ENABLED', false),
    config: {
      REMEMBER_ME: env.bool('SSO_REMEMBER_ME', false),

      // Authentik OIDC
      OIDC_REDIRECT_URI: env('SSO_OIDC_REDIRECT_URI'),
      OIDC_CLIENT_ID: env('SSO_OIDC_CLIENT_ID'),
      OIDC_CLIENT_SECRET: env('SSO_OIDC_CLIENT_SECRET'),
      OIDC_SCOPES: env('SSO_OIDC_SCOPES', 'openid profile email'),
      OIDC_AUTHORIZATION_ENDPOINT: env('SSO_OIDC_AUTHORIZATION_ENDPOINT'),
      OIDC_TOKEN_ENDPOINT: env('SSO_OIDC_TOKEN_ENDPOINT'),
      OIDC_USER_INFO_ENDPOINT: env('SSO_OIDC_USER_INFO_ENDPOINT'),
      OIDC_USER_INFO_ENDPOINT_WITH_AUTH_HEADER: env.bool('SSO_OIDC_USER_INFO_ENDPOINT_WITH_AUTH_HEADER', true),
      OIDC_GRANT_TYPE: env('SSO_OIDC_GRANT_TYPE', 'authorization_code'),
      OIDC_FAMILY_NAME_FIELD: env('SSO_OIDC_FAMILY_NAME_FIELD', 'family_name'),
      OIDC_GIVEN_NAME_FIELD: env('SSO_OIDC_GIVEN_NAME_FIELD', 'given_name'),

      USE_WHITELIST: env.bool('SSO_USE_WHITELIST', false),
    },
  },
});
