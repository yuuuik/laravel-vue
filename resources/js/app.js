import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import Layout from './Shared/Layout';

createInertiaApp({
    resolve: name => {
        const page = require(`./Pages/${name}.vue`).default
        page.layout = page.layout || Layout

        return page
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin);
        
        
        app.config.globalProperties.route = window.route;
    
        app.mount(el);
    },
    
})
