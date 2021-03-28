const routes = [
    {
        path: ``,
        name: 'home',
        component: () => import('@/views/home/Home.vue'),
    },
    {
        path: `/tags`,
        name: 'tags',
        component: () => import('@/views/Tags.vue'),
    },
    {
        path: '*',
        name: '404',
        component: () => import('@/views/404.vue'),
    }
];

export default routes;
