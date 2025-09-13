
export default {
  bootstrap: () => import('./main.server.mjs').then(m => m.default),
  inlineCriticalCss: true,
  baseHref: '/angular/',
  locale: undefined,
  routes: [
  {
    "renderMode": 2,
    "route": "/angular"
  },
  {
    "renderMode": 2,
    "route": "/angular/about"
  },
  {
    "renderMode": 2,
    "route": "/angular/login"
  }
],
  entryPointToBrowserMapping: undefined,
  assets: {
    'index.csr.html': {size: 5032, hash: '24e0bf12818d435b186d3ae06c9243ba6903c2c5f705954f1461c5e49170b23f', text: () => import('./assets-chunks/index_csr_html.mjs').then(m => m.default)},
    'index.server.html': {size: 1004, hash: '9ed966c2dd9f911d91a05f5e48c48d16519231b32a60da7ed816d7ddd572ac8b', text: () => import('./assets-chunks/index_server_html.mjs').then(m => m.default)},
    'login/index.html': {size: 19608, hash: '37d1bb59609f7e91a758876a4696c78586c630e7b8295ffee361ba0f98a03282', text: () => import('./assets-chunks/login_index_html.mjs').then(m => m.default)},
    'about/index.html': {size: 31707, hash: 'f5072fb8ef7bed4b028aefd531bba3124ecd964caaaa39a747a9115f40b471a4', text: () => import('./assets-chunks/about_index_html.mjs').then(m => m.default)},
    'index.html': {size: 43519, hash: '6fa2822d5bff2a7f4b28ae3e717bef243760329913abe0719e5a6a9d8b806951', text: () => import('./assets-chunks/index_html.mjs').then(m => m.default)},
    'styles-BVJQD57C.css': {size: 230873, hash: 'YU+im7r2LDs', text: () => import('./assets-chunks/styles-BVJQD57C_css.mjs').then(m => m.default)}
  },
};
