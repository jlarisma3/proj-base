require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const projectDir = window.document.getElementsByTagName('project-view')[0]?.innerText || 'Project';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./${projectDir}/${name}.vue`),
    setup({ el, app, props, plugin }) {

        const vApp =  createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })

        vApp.config.globalProperties.userCan = (routeName) => {
            if(routeName.length == 0)
                return false;

            let auths = usePage()
                .props
                .value?.access;

            return auths.some(r => r.route_name == routeName);
        };

        vApp.mount(el)

        return vApp;
    },
});

InertiaProgress.init({ color: '#4B5563' });
