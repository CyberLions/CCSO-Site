import type { StrapiApp } from '@strapi/strapi/admin';

export default {
  config: {
    locales: [],
  },
  bootstrap(app: StrapiApp) {
    const { pathname, search } = window.location;
    const bypassPassword = new URLSearchParams(search).get('password') === '1';

    if (pathname === '/admin/auth/login' && !bypassPassword) {
      window.location.replace('/strapi-plugin-sso/oidc');
    }
  },
};
