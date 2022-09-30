export default [
    { path: '/', redirect: '/dashboard' },

    {
        path: '/dashboard',
        name: 'dashboard',
        component: require('./Screens/dashboard').default,
    },

    {
        path: '/workflows/running',
        name: 'workflows.running',
        component: require('./Screens/workflows/running').default,
    },

    {
        path: '/workflows/finished',
        name: 'workflows.finished',
        component: require('./Screens/workflows/finished').default,
    },

    {
        path: '/workflows/failed',
        name: 'workflows.failed',
        component: require('./Screens/workflows/failed').default,
    },

    {
        path: '/workflows/:id',
        name: 'workflows.show',
        component: require('./Screens/workflows/show').default,
    },
];
