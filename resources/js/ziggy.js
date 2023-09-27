const Ziggy = {
    url: "http://localhost",
    port: null,
    defaults: {},
    routes: {
      home: { uri: "/", methods: ["GET", "HEAD"] },
      about: { uri: "about", methods: ["GET", "HEAD"] },
      "articles.indexCreate": { uri: "articles/indexCreate", methods: ["GET", "HEAD"] },
        "api.users.index": { uri: "api/users", methods: ["GET"] },
        'api.users.destroy': { uri: 'api/users/{user}', methods: ['DELETE'], bindings: { user: 'id' } },
      "articles.indexEdit": { uri: "articles/indexEdit/{id}", methods: ["GET", "HEAD"] },
      "users.index": { uri: "users", methods: ["GET", "HEAD"] },
      "users.create": { uri: "users/create", methods: ["GET", "HEAD"] },
      "users.store": { uri: "users", methods: ["POST"] },
      "users.show": { uri: "users/{user}", methods: ["GET", "HEAD"], bindings: { user: "id" } },
      "users.edit": { uri: "users/{user}/edit", methods: ["GET", "HEAD"], bindings: { user: "id" } },
      "users.update": { uri: "users/{user}", methods: ["PUT", "PATCH"], bindings: { user: "id" } },
      "users.destroy": { uri: "users/{user}", methods: ["DELETE"], bindings: { user: "id" } },
      "articles.index": { uri: "articles", methods: ["GET", "HEAD"] },
      "articles.create": { uri: "articles/create", methods: ["GET", "HEAD"] },
      "articles.store": { uri: "articles", methods: ["POST"] },
      "articles.show": { uri: "articles/{article}", methods: ["GET", "HEAD"] },
      "articles.edit": { uri: "articles/{article}/edit", methods: ["GET", "HEAD"], bindings: { article: "id" } },
      "articles.update": { uri: "articles/{article}", methods: ["PUT", "PATCH"], bindings: { article: "id" } },
      "articles.destroy": { uri: "articles/{article}", methods: ["DELETE"], bindings: { article: "id" } },
      login: { uri: "login", methods: ["POST"] },
      logout: { uri: "logout", methods: ["DELETE"] },
    },
  };

  if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
  }

  export { Ziggy };
